### 📆 PROJETO DE ESTÁGIO - AGENDA SENAI 2015

------



Projetinho realizado no período de estágio dentro do SENAI PERNAMBUCO. 

Critérios estabelecidos pelo coordenador do núcleo de TI.



**Objetivo:**

Desenvolver uma agenda que fique online no servidor, conectado com o banco de dados da empresa, e criar um banco próprio e cadastrar: *cargo, contato, departamento, telefone, unidade e tipo da unidade*, dos **colaboradores**. O objetivo era substituir a agenda criada em uma página HTML no qual, qualquer alteração, era feita manualmente. Basicamente os colaboradores procuram outros colaboradores, afim de descobrir ramal de onde a pessoa se encontra, unidade e talvez o telefone pessoal ( se tiver cadastrado ).



**Projeto:** 

Foi criado uma agenda em desenvolvimento web, usando as seguintes ferramentas: PHP, JAVASCRIPT, HTML, CSS, AJAX, BOOTSTRAP e banco de dados SQL SERVER. 

**Funcional:** 

No funcionamento da agenda, terão perfís distintos: 

<b>Super Usuário:</b>
Pode -> adicionar, editar, atualizar e remover o colaborador. (OBS: Foi criado um parâmetro que passamos na barra de endereço para que apareça afunção de super usuário )
<br/>
<b>Colaborador:</b>
Pode -> apenas visualizar e consultar contatos

#
#### 0.1 Imagens
<br/>

### SCREEN 01 ( Apena visualização )
<img img width="600" src="https://github.com/JoanesAraujo/Joanes_Screenshot/blob/master/imagem_agenda_senai/agenda_01.png">

### SCREEN 02 ( Join do departamento no banco Sql Server para ser visualizado na SCREEN 1)
<img img width="600" src="https://github.com/JoanesAraujo/Joanes_Screenshot/blob/master/imagem_agenda_senai/agenda_001.png">

### SCREEN 03 ( ?super=usuario - Liberando o perfil de super usuário )
<img img width="600" src="https://github.com/JoanesAraujo/Joanes_Screenshot/blob/master/imagem_agenda_senai/agenda_02.png">

### SCREEN 04 ( Cadastrando usuário pela interface )
<img img width="600" src="https://github.com/JoanesAraujo/Joanes_Screenshot/blob/master/imagem_agenda_senai/agenda_03.png">

### SCREEN 05 ( Depois de adicionar o usuário, pode cadastrar o número de telefone )
<img img width="600" src="https://github.com/JoanesAraujo/Joanes_Screenshot/blob/master/imagem_agenda_senai/agenda_0004.png">

### SCREEN 06 ( Inserindo usuário pelo banco sql server )
<img img width="600" src="https://github.com/JoanesAraujo/Joanes_Screenshot/blob/master/imagem_agenda_senai/agenda_05.png">

### SCREEN 07 ( SELECT na base de dados do usuário )
<img img width="600" src="https://github.com/JoanesAraujo/Joanes_Screenshot/blob/master/imagem_agenda_senai/agenda_06.png">

### SCREEN 08 ( Visualização do usuário colaborador )
<img img width="600" src="https://github.com/JoanesAraujo/Joanes_Screenshot/blob/master/imagem_agenda_senai/agenda_07.png">


#
#### 0.2 Projeto Agenda SENAI schema





<img img width="600" src="https://github.com/JoanesAraujo/Joanes_Screenshot/blob/master/imagem_agenda_senai/schema.png">


#
#### 0.3 Script da tabela no banco de dados Sql Server 2008 R2
<br/>


<img width="600" img src="https://github.com/JoanesAraujo/Joanes_Screenshot/blob/master/imagem_agenda_senai/banco.JPG">



Obs: O projeto não foi implementado por falta de tempo. Não existe problema com a base de dados aqui apresentada, na questão de exposição de dados da empresa, já que a mesma unificou todo o sistema "S" ( SENAI, SESI, FIEPE, IEL) E , esse banco, **nunca foi rodado**.
