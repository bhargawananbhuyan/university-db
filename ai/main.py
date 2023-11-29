from spacy.lang.en import English
import numpy
from flask import Flask, request, jsonify
import pickle
import random
from keras.models import load_model
from flask_cors import CORS

nlp = English()
tokenizer = nlp.Defaults.create_tokenizer(nlp)
PAD_Token=0

app = Flask(__name__)
CORS(app)
     
model= load_model('chatbot_model')
        
with open("intents.pickle", "rb") as f:
    data = pickle.load(f)

def predict(ques):
    ques= data.getQuestionInNum(ques)
    ques=numpy.array(ques)
    ques = numpy.expand_dims(ques, axis = 0)
    y_pred = model.predict(ques)
    res=numpy.argmax(y_pred, axis=1)
    return res
    

def get_response(results):
    tag= data.index2tags[int(results)]
    response= data.response[tag]
    return response

def chat(inp):
    while True:
        inp_x=inp.lower()
        results = predict(inp_x)
        response= get_response(results)
        return random.choice(response)

@app.post("/chat")
def get_bot_response():
    data = request.get_json()
    user_message = data['message']
    return jsonify({'message': chat(user_message)})

if __name__ == "__main__":
        app.run(debug=True)
 