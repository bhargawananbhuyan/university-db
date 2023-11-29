from spacy.lang.en import English
nlp = English()

class Utils:
    def __init__(self):
        self.num_words = 1
        self.num_tags = 0
        self.tags = {}
        self.index2tags = {}
        self.questions = {}
        self.word2index = {}
        self.responses = {}
  
    def add_word(self, word):
        if word not in self.word2index:
            self.word2index[word] = self.num_words
            self.num_words += 1

    def add_tags(self, tag):
        if tag not in self.tags:
            self.tags[tag] = self.num_tags
            self.index2tags[self.num_tags] = tag
            self.num_tags += 1
            
    def add_question(self, question, answer):
        self.questions[question] = answer
        words = self.tokenization(question)
        for word in words:
            self.add_word(word)
                 
    def tokenization(self, ques):
        tokens = nlp(ques)
        token_list = []
        for token in tokens:
            token_list.append(token.lemma_)
        return token_list
    
    def get_index_of_word(self, word):
        return self.word2index[word]
    
    def get_question_in_num(self, ques):
        words = self.tokenization(ques)
        tmp = [0 for _ in range(self.num_words)]
        for word in words:
            tmp[self.get_index_of_word(word)] = 1
        return tmp
    
    def get_tag(self, tag):
        tmp = [0.0 for _ in range(self.num_tags)]
        tmp[self.tags[tag]] = 1.0
        return tmp
    
    def get_vocab_size(self):
        return self.num_words
    
    def get_tag_size(self):
        return self.num_tags

    def add_response(self, tag, responses):
        self.responses[tag] = responses
