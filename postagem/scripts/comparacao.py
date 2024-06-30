import streamlit as st
import requests
from PIL import Image
from io import BytesIO
import pandas as pd
import plotly.graph_objects as go
import mysql.connector
import json
import os

# Função para baixar a imagem da URL
def carregar_imagem(url):
    response = requests.get(url)
    image = Image.open(BytesIO(response.content))
    return image

# Conectar ao banco de dados MySQL
def conectar_mysql():
    return mysql.connector.connect(
      user='root', password='',
      host='localhost',
      database='vlsa'
    )

# Ler os IDs do arquivo JSON
with open('../postagem/id_comparacao.json', 'r') as file:
    ids = json.load(file)
    id_post_1 = ids['id1']
    id_post_2 = ids['id2']

# Buscar dados no MySQL
conn = conectar_mysql()
cursor = conn.cursor(dictionary=True)

cursor.execute('SELECT * FROM postagens WHERE idPostagem = %s', (id_post_1,))
dados_post_1 = cursor.fetchone()

cursor.execute('SELECT * FROM postagens WHERE idPostagem = %s', (id_post_2,))
dados_post_2 = cursor.fetchone()

conn.close()

# Aqui você pode processar dados_post_1 e dados_post_2 conforme necessário
# Por exemplo, você pode usar dados_post_1['url_imagem'] para obter a URL da imagem da postagem 1

# Carregar os dados de análise
df1 = pd.read_csv('analysis_data.csv')
df2 = pd.read_csv('./scripts/analysis_data_2.csv')

# Carregar imagens das postagens
nome_do_arquivo = dados_post_1['imgPost'].replace('./', '')  # Remove o './' do caminho

# Construir o caminho completo para o arquivo da imagem
caminho_completo = os.path.join(os.path.dirname(__file__), '..', '', nome_do_arquivo)

nome_do_arquivo2 = dados_post_2['imgPost'].replace('./', '')

caminho_completo2 = os.path.join(os.path.dirname(__file__), '..', '', nome_do_arquivo2)
# Carregar a imagem
imagem_post1 = Image.open(caminho_completo)
imagem_post2 = Image.open(caminho_completo2)

# Redimensionar as imagens
imagem_post1.thumbnail((550, 550))
imagem_post2.thumbnail((550, 550))

# Definir a ordem das polaridades e cores associadas
polaridade_order = ['positivo', 'neutro', 'negativo']
cores = {'positivo': 'green', 'neutro': 'blue', 'negativo': 'red'}

# Contagem de ocorrências de cada polaridade
polaridade_counts1 = df1['polaridade'].value_counts().reindex(polaridade_order, fill_value=0)
polaridade_counts2 = df2['polaridade'].value_counts().reindex(polaridade_order, fill_value=0)

# Normalização dos valores para representar porcentagens
polaridade_percentages1 = (polaridade_counts1 / polaridade_counts1.sum()) * 100
polaridade_percentages2 = (polaridade_counts2 / polaridade_counts2.sum()) * 100

# Configuração da página
st.set_page_config(page_title='Análise de Sentimentos', page_icon=':bar_chart:', layout="wide")

# Título
st.title(":bar_chart: Comparação de Sentimentos entre Duas Postagens")

# Colunas para as imagens e gráficos
col_imagem1, col_imagem2 = st.columns([1, 1])
col_graficos1, col_graficos2 = st.columns([1, 1])

# Exibir as imagens das postagens com legendas
col_imagem1.image(imagem_post1, caption='Imagem da Postagem 1')
col_imagem2.image(imagem_post2, caption='Imagem da Postagem 2')

# Gráfico de Barras Convencional para Postagem 1
col_graficos1.subheader("Gráfico de Barras - Postagem 1")
fig_barras_convencional1 = go.Figure(go.Bar(
    x=polaridade_percentages1.index,
    y=polaridade_percentages1.values,
    marker_color=[cores[p] for p in polaridade_order],
))

fig_barras_convencional1.update_layout(
    title='Distribuição da Polaridade dos Comentários - Postagem 1',
    xaxis=dict(title='Polaridade', categoryorder='array', categoryarray=polaridade_order),
    yaxis=dict(title='Porcentagem', range=[0, 100]),
    width=500,
    height=500,
    margin=dict(l=20, r=20, t=40, b=20)  # Ajuste de margens
)

col_graficos1.plotly_chart(fig_barras_convencional1)

# Gráfico de Pizza para Postagem 1
col_graficos1.subheader("Gráfico de Pizza - Postagem 1")
fig_pizza1 = go.Figure(data=[go.Pie(labels=polaridade_counts1.index, values=polaridade_counts1.values, hole=.3)])

fig_pizza1.update_traces(marker=dict(colors=[cores[p] for p in polaridade_order]))

fig_pizza1.update_layout(
    title='Distribuição da Polaridade dos Comentários - Postagem 1',
    width=500,
    height=500,
    margin=dict(l=20, r=20, t=40, b=20)  # Ajuste de margens
)

col_graficos1.plotly_chart(fig_pizza1)

# Gráfico de Barras Convencional para Postagem 2
col_graficos2.subheader("Gráfico de Barras - Postagem 2")
fig_barras_convencional2 = go.Figure(go.Bar(
    x=polaridade_percentages2.index,
    y=polaridade_percentages2.values,
    marker_color=[cores[p] for p in polaridade_order],
))

fig_barras_convencional2.update_layout(
    title='Distribuição da Polaridade dos Comentários - Postagem 2',
    xaxis=dict(title='Polaridade', categoryorder='array', categoryarray=polaridade_order),
    yaxis=dict(title='Porcentagem', range=[0, 100]),
    width=500,
    height=500,
    margin=dict(l=20, r=20, t=40, b=20)  # Ajuste de margens
)

col_graficos2.plotly_chart(fig_barras_convencional2)

# Gráfico de Pizza para Postagem 2
col_graficos2.subheader("Gráfico de Pizza - Postagem 2")
fig_pizza2 = go.Figure(data=[go.Pie(labels=polaridade_counts2.index, values=polaridade_counts2.values, hole=.3)])

fig_pizza2.update_traces(marker=dict(colors=[cores[p] for p in polaridade_order]))

fig_pizza2.update_layout(
    title='Distribuição da Polaridade dos Comentários - Postagem 2',
    width=500,
    height=500,
    margin=dict(l=20, r=20, t=40, b=20)  # Ajuste de margens
)

col_graficos2.plotly_chart(fig_pizza2)

# Gráfico de Comparação de Barras
st.subheader("Comparação de Barras entre as Postagens")
fig_comparacao = go.Figure(data=[
    go.Bar(name='Postagem 1', x=polaridade_percentages1.index, y=polaridade_percentages1.values, marker_color='yellow'),
    go.Bar(name='Postagem 2', x=polaridade_percentages2.index, y=polaridade_percentages2.values, marker_color='brown')
])

fig_comparacao.update_layout(
    title='Comparação da Polaridade dos Comentários entre as Postagens',
    xaxis=dict(title='Polaridade', categoryorder='array', categoryarray=polaridade_order),
    yaxis=dict(title='Porcentagem', range=[0, 100]),
    barmode='group',
    width=1400,  # Aumenta o tamanho do gráfico
    height=700,  # Aumenta o tamanho do gráfico
    margin=dict(l=20, r=20, t=40, b=20)  # Ajuste de margens
)

st.plotly_chart(fig_comparacao)
