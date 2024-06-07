import nltk
from nltk.sentiment import SentimentIntensityAnalyzer
from translate import Translator
import gender_guesser.detector as gender

nltk.download('vader_lexicon')

text = "Bela imagem"
sia = SentimentIntensityAnalyzer()

dicionario_sentimento = {
    "Horrível": {"traducao": "dreadful", "sentimento": -1},
    "Péssimo": {"traducao": "terrible", "sentimento": -1},
    "Ruim": {"traducao": "bad", "sentimento": -1},
    "Bom": {"traducao": "good", "sentimento": 1},
    "Ótimo": {"traducao": "excellent", "sentimento": 1},
    "Maravilhoso": {"traducao": "wonderful", "sentimento": 1},
    "Horroroso": {"traducao": "horrible","sentimento":-1},
}

def identificar_genero_e_introduzir_no_dicionario(palavra):
    d = gender.Detector()
    genero = d.get_gender(palavra)
    tradutor = Translator(from_lang='pt-br', to_lang='en')
    traducao = tradutor.translate(str(palavra))
    
    # Adicione a palavra, a tradução, o gênero e o sentimento ao dicionário
    dicionario_sentimento[palavra] = {"traducao": traducao, "genero": genero, "sentimento": 0}

def aumentar_valor_itens_dicionario():
    for palavra in dicionario_sentimento:
        dicionario_sentimento[palavra]["sentimento"] += 1

def traduzir(comentario):
  tradutor = Translator(from_lang='pt-br', to_lang='en')
  traducao = tradutor.translate(str(comentario))

  # Verifique se a palavra está no dicionário
  if comentario in dicionario_sentimento:
    # Use a tradução e o sentimento do dicionário
    traducao = dicionario_sentimento[comentario]["traducao"]
    sentimento = dicionario_sentimento[comentario]["sentimento"]
  else:
    # Adicione a palavra ao dicionário e obtenha o gênero
    identificar_genero_e_introduzir_no_dicionario(comentario)
    # Use a tradução e o sentimento do dicionário
    traducao = dicionario_sentimento[comentario]["traducao"]
    sentimento = dicionario_sentimento[comentario]["sentimento"]

  return traducao, sentimento

# Chame a função para identificar o gênero e introduzir no dicionário
identificar_genero_e_introduzir_no_dicionario(text)

# Chame a função para aumentar o valor dos itens do dicionário
aumentar_valor_itens_dicionario()

traducao, sentimento = traduzir(text)
sentiment_score = sia.polarity_scores(traducao)

print(f"Tradução: {traducao}")
print(f"Texto original: {text}")
print(f"Pontuação de sentimento VADER: {sentiment_score}")
print(f"Sentimento do dicionário: {sentimento}")