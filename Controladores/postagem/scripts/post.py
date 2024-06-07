import streamlit as st
import requests
from PIL import Image
from io import BytesIO
import pandas as pd
import plotly.graph_objects as go
import mysql.connector
import json

# Ler a URL da imagem do arquivo

with open('session_data.json', 'r') as f:
    serializedData = f.read()

# Deserialize JSON data to Python object
sessionData = json.loads(serializedData)

userId = sessionData["userId"]
idPost = sessionData['id']

cnx = mysql.connector.connect(user='root', password='',
                              host='localhost',
                              database='vlsa')
cursor = cnx.cursor()

# Consulta SQL para buscar os dados de análise
query = f"SELECT comentario, polaridade FROM comentarios WHERE idUsuario = {userId} and idPostagens = {idPost}"

# Executa a consulta SQL
cursor.execute(query)

# Busca os dados de análise
dados = cursor.fetchall()

# Fecha a conexão com o banco de dados
cursor.close()
cnx.close()

cnx = mysql.connector.connect(user='root', password='',
                              host='localhost',
                              database='vlsa')
cursor = cnx.cursor()

query = f"SELECT Nome_postagens, imgPost FROM postagens WHERE idUsuarios = {userId} and idPostagens = {idPost}"

# Executa a consulta SQL
cursor.execute(query)

# Busca os dados de análise
postagem = cursor.fetchall()

# Fecha a conexão com o banco de dados
cursor.close()
cnx.close()

df2 = pd.DataFrame(postagem, columns=['Nome', 'Img'])
imagem = df2['Img'][0]
nome = df2['Nome'][0]
# Cria um DataFrame com os dados de análise
df = pd.DataFrame(dados, columns=['comentario', 'polaridade'])

# Contagem de ocorrências de cada polaridade
polaridade_counts = df['polaridade'].value_counts()

# Normalização dos valores para representar porcentagens
polaridade_percentages = (polaridade_counts / polaridade_counts.sum()) * 100

# Configuração da página
st.set_page_config(page_title='Análise de Sentimentos', page_icon=':bar_chart:', layout="wide")

# Título
st.title(":bar_chart: Análise de Sentimentos")

# Coluna para a imagem e gráficos
col_imagem, col_graficos = st.columns([3, 3])

# Ajustando o tamanho da barra lateral
col_imagem.markdown("<style>div.Widget.row-widget.stRadio>div{flex-direction:column;width:80%}</style>", unsafe_allow_html=True)

# Exibir a imagem da postagem com uma borda
col_imagem.image(imagem, caption=nome)

# Gráfico de Barras Convencional
col_graficos.subheader("Gráfico de Barras ")
fig_barras_convencional = go.Figure(go.Bar(
    x=polaridade_percentages.index,
    y=polaridade_percentages.values,
    marker_color=['blue', 'green', 'red'],
))

fig_barras_convencional.update_layout(
    title='Distribuição da Polaridade dos Comentários',
    xaxis=dict(title='Polaridade'),
    yaxis=dict(title='Porcentagem', range=[0, 100]),
    width=500,
    height=500,
    margin=dict(l=20, r=20, t=40, b=20)  # Ajuste de margens
)

col_graficos.plotly_chart(fig_barras_convencional)

# Gráfico de Pizza
col_graficos.subheader("Gráfico de Pizza")
fig_pizza = go.Figure(data=[go.Pie(labels=polaridade_counts.index, values=polaridade_counts.values, hole=.3)])

fig_pizza.update_traces(marker=dict(colors=['blue', 'green', 'red']))

fig_pizza.update_layout(
    title='Distribuição da Polaridade dos Comentários',
    width=500,
    height=500,
    margin=dict(l=20, r=20, t=40, b=20)  # Ajuste de margens
)

col_graficos.plotly_chart(fig_pizza)