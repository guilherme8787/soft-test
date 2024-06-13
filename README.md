# SoftTest

## Faça a instalação do Docker

### Passo a passo

- Navegue até o link abaixo e selecione seu SO

  - https://docs.docker.com/engine/install/

- Use o script convencional, no exemplo abaixo a instação para debian, para windows acesse o docker desktop

  - https://docs.docker.com/engine/install/debian/#install-using-the-convenience-script

- Execute o "Post instalation steps"

  - https://docs.docker.com/engine/install/linux-postinstall/

- Teste digitando
  - `docker ps`

### Com o docker instalado nós vamos executar o comando abaixo para criar a network

`docker network create --subnet=172.18.0.0/16 soft-test`

`docker compose up -d`

### Feito isso basta abrir o browser e navegar no projeto

http://127.0.0.1:8000
