# Melhoria de desempenho

Nossos clientes tem reclamado muito da experiência nas páginas de listagem e detalhes de produtos. A principal 
reclamação é que o filtro dos produtos não funciona, porém temos diversas reclamações informando que a página é lenta, 
muitas vezes ela trava ou mesmo a guia inteira do navegador trava. Reclamações de que a página é lenta entre outras.

Como se trata de um projeto legado, diversas pessoas já mexeram na página, muitas regras de negócio mudaram ou foram
adicionadas o que resultou nesses problemas de falhas, desempenho, acessebilidade e usabilidade.

## Seu objetivo nessa tarefa é:

1. Fazer com que o filtro de produtos funcione: reimplemente o filtro de produtos para que ele seja exibido baseado
nas características dos produtos que foram carregados na página e que de fato filtrem os produtos quando alguma opção
é aplicada.
2. Melhore o desempenho da página: encontre todos os problemas que podem contribuir para o desempenho ruim da página, 
tanto no backend quanto no frontend. Utilize os melhores padrões para web e **não se esqueça de informar em seu Merge
Request quais foram os problemas encontrados.**
3. Organize todo o código: modifique o código de acordo com bons padrões para facilitar a adição de novas 
funcionalidades.

## O que esperamos receber:

Neste projeto você pode alterar o código da maneira que preferir. Remover qualquer funcionalidade é válido desde que
justificadas em seu MR. Esperamos que os pontos abaixo sejam entregues:

* O filtro de produtos funcionando como descrito
* Página de listagem de produtos e destalhes de produtos sem gargalos, fluidas e otimizadas para o acesso do usuário
* Código bem organizado e limpo

Caso consiga entregar testes automatizados, ferramentas de análise de código para prevenção de bugs, otimizações de
processos como minificação de arquivos css e js, inlining, entre outros, isso será bem visto e considerado na avaliação.

**Não é necessário fazer uma entrega perfeita. Nem todos os problemas são fáceis de encontrar ou simples de resolver.
Entregue o que conseguir e coloque todas as informações que achar necessárias na descrição do seu MR.**

## Abaixo seguem alguns materiais que podem te ajudar completar a tarefa:

* [Manual do Zend Framework 1](https://framework.zend.com/manual/1.12/en/manual.html)
* [SOLID: Teoria bonita, prática confusa?](https://open.spotify.com/episode/7KaHkZC87fBoH5Oylyv9da?go=1&sp_cid=ac9787951d8f74cab9d48faabc19d17d&utm_source=embed_player_p&utm_medium=desktop&si=NIx86OxPRsyNMPD3r2CGXA&nd=1&dlsi=562af806ff3443d3)
* [Desconstructing SOLID design principles](https://www.tedinski.com/2019/04/02/solid-critique.html)
* [Cognitive load](https://github.com/zakirullin/cognitive-load)
* [Desempenho de renderizações](https://web.dev/articles/rendering-performance?hl=pt-br#the-pixel-pipeline)
* [The anatomy of a frame](https://aerotwist.com/blog/the-anatomy-of-a-frame/)

## Informações importantes sobre o ambiente

Todo o ambiente está configurado no `docker-compose.yml`, então é necessário que você possua o docker instalado em sua
máquina.

Ao iniciar o serviço com `docker compose up -d` o banco de dados será criado e populado automaticamente com os dados que
se encontram em `init/init.sql`. Antes de começar verifique se o banco de dados está no ar e populado com os dados.

O ambiente é um servidor com PHP 7.2 e Apache 2 e o banco de dados é o MySQL na versão 8.0.

## Instruções para a entrega

Siga as instruções abaixo para realizar a entrega do projeto:

- faça um fork do repositório no gitlab para sua conta;
- faça as modificações solicitadas no seu novo repositório;
- crie o merge request a partir do fork. Quando você submete o código no seu próprio repositório, o gitlab dá a opção
de enviar as mudanças para o upstream;
- Na descrição do MR informe o que foi feito e justifique suas decisões.
