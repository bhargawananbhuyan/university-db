import numpy as np
import json
from keras.models import Sequential, save_model
from keras.layers import Dense, Activation
import pickle
from utils import Utils

def splitDataset(data):
    x_train = [data.get_question_in_num(x) for x in data.questions]
    y_train = [data.get_tag(data.questions[x]) for x in data.questions]
    return x_train, y_train

with open("intents.json") as file:
    raw_data = json.load(file)

data = Utils()

for intent in raw_data["intents"]:
    tag = intent["tag"]
    data.add_tags(tag)

    for question in intent["patterns"]:
        ques = question.lower()
        data.add_question(ques, tag)

x_train, y_train = splitDataset(data)
x_train = np.array(x_train)
y_train = np.array(y_train)

model = Sequential()
model.add(Dense(units=12, input_dim=len(x_train[0])))
model.add(Activation('relu'))
model.add(Dense(units=8))
model.add(Activation('relu'))
model.add(Dense(units=38))
model.add(Activation('softmax'))

model.compile(optimizer='adam', loss='categorical_crossentropy', metrics=['accuracy'])
model.fit(x_train, y_train, batch_size=10, epochs=100)
save_model("chatbot_model")

data.questions = {}

for intent in raw_data["intents"]:
    tag = intent["tag"]
    response = []
    for resp in intent["responses"]:
        response.append(resp)
    data.add_response(tag, response)

with open('intents.pickle', 'wb') as handle:
    pickle.dump(data, handle)