# Preparar o ambiente, instalar extensões necessárias e publicar no Git

## Objetivo

Execute as tarefas descritas neste documento no workspace existente do portfólio `levicavadas.dev` e dos projetos relacionados. O objetivo é preparar o ambiente de desenvolvimento, instalar somente as extensões e dependências que forem realmente necessárias, adicionar este documento ao repositório e publicar as alterações no remoto correto quando houver acesso autorizado.

**Não entregue apenas um plano. Inspecione o ambiente e execute as etapas possíveis.** Informe com clareza qualquer ação que dependa de autorização, credenciais ou intervenção manual.

## 1. Inspecionar o ambiente antes de alterar qualquer coisa

1. Identifique o sistema operacional, o editor utilizado (por exemplo, VS Code), as ferramentas disponíveis e a raiz correta do repositório.
2. Inspecione a estrutura e os arquivos do projeto antes de instalar ferramentas ou alterar configurações.
3. Verifique quais tecnologias o projeto realmente utiliza. Não presuma que o projeto usa PHP, Node.js, React, TypeScript, MySQL ou qualquer ferramenta sem confirmar isso nos arquivos existentes.
4. Verifique o estado do Git: branch atual, `git status`, remoto configurado, alterações não commitadas e arquivos ignorados.
5. Preserve as alterações locais do usuário. **Não descarte, sobrescreva, reinicie ou limpe alterações existentes** para facilitar o processo.
6. Não mostre valores secretos encontrados em arquivos de configuração, variáveis de ambiente, logs ou histórico do terminal.

## 2. Instalar as extensões e ferramentas necessárias

Instale apenas o que for aplicável ao projeto e ao ambiente encontrado. Antes de instalar, verifique se cada extensão ou ferramenta já está presente.

### Extensões do editor

Se o ambiente for Visual Studio Code, avalie e instale apenas as extensões úteis para as tecnologias confirmadas no projeto. Exemplos condicionais:

- **PHP:** PHP Intelephense; PHP Debug somente se houver necessidade de depuração e configuração compatível.
- **JavaScript/TypeScript/React:** ESLint e Prettier, respeitando as ferramentas e configurações já existentes no repositório.
- **SQL/MySQL:** extensão de suporte a SQL ou MySQL somente se facilitar o trabalho necessário. Não salve senhas de banco em configurações do editor.
- **Git:** use os recursos nativos do editor sempre que forem suficientes. Extensões adicionais são opcionais, não obrigatórias.
- **Formatação e padronização:** EditorConfig somente se fizer sentido para o projeto ou se já houver configuração correspondente.

Não instale todas as extensões da lista por padrão. Confirme compatibilidade, origem confiável e necessidade. Prefira o Marketplace oficial e os identificadores oficiais das extensões. Não instale extensões com origem duvidosa.

Se o VS Code estiver disponível e a instalação por linha de comando for apropriada, utilize `code --install-extension <publisher.extension>` para as extensões selecionadas e depois confirme a instalação. Se o comando `code` não estiver disponível, não faça mudanças improvisadas no sistema: explique a limitação e forneça o passo manual necessário.

### Ferramentas e extensões do runtime

Diferencie **extensões do editor** de **extensões de linguagem/runtime**. Instale ou habilite extensões de PHP, Composer, Node.js ou MySQL somente se forem realmente exigidas pelo projeto e estiverem ausentes. Se o projeto utilizar PHP com PDO/MySQL, confirme especificamente que o PHP CLI correto carrega `pdo_mysql` e que o driver corresponde à instalação ativa. Não altere versões ou arquivos de configuração sem antes identificar o executável e o arquivo de configuração em uso.

Não reinstale ferramentas já funcionais sem motivo. Antes de qualquer instalação, verifique se ela pode exigir privilégios administrativos, reinicialização ou aprovação do usuário. Peça autorização quando necessário, sem tentar contornar as permissões do sistema.

## 3. Revisar as dependências do projeto

1. Inspecione os arquivos de manifesto existentes, como `package.json`, `composer.json`, arquivos de lock e configurações de build ou testes.
2. Instale apenas dependências de projeto necessárias e compatíveis com os manifestos e arquivos de lock existentes.
3. Preserve os arquivos de lock. Não atualize todas as dependências indiscriminadamente e não introduza bibliotecas redundantes.
4. Nunca comite `node_modules`, diretórios de build gerados que não façam parte do fluxo do projeto, arquivos de cache, credenciais, chaves, arquivos `.env` ou dumps com dados privados.
5. Se houver dependências faltando, explique por que são necessárias e valide a instalação com os comandos apropriados ao projeto.

## 4. Adicionar este documento ao repositório

1. Salve uma cópia deste arquivo, com o nome `CLAUDE_EXTENSOES_E_PUBLICAR_NO_GIT.md`, na raiz do repositório correto.
2. Confirme que o arquivo foi salvo com o conteúdo integral e que não foi colocado por engano dentro de `public/`, `dist/`, `build/`, `vendor/`, `node_modules/` ou outro diretório gerado.
3. Revise `git status` e confirme que o documento aparece entre os arquivos a serem versionados.
4. Se já existir um documento com o mesmo nome e conteúdo diferente, não o sobrescreva silenciosamente. Compare os conteúdos e escolha uma solução segura; se a decisão puder apagar trabalho do usuário, peça orientação.

## 5. Preparar o Git com segurança

1. Confirme qual é o repositório remoto correto (`git remote -v`) e qual branch deve receber as alterações.
2. Se não houver um remoto configurado, ou não for possível confirmar que ele pertence ao usuário, **pergunte pelo endereço HTTPS ou SSH do repositório e pela branch desejada** antes de publicar.
3. Se o Git exigir autenticação, peça ao usuário que conclua a autenticação pelo mecanismo oficial, como o Git Credential Manager, `gh auth login` (se GitHub CLI estiver instalado e for apropriado) ou a configuração SSH. **Nunca solicite que o usuário envie senha, token pessoal ou chave privada diretamente na conversa.** Nunca escreva credenciais nos arquivos do projeto.
4. Não crie um repositório público, não altere a visibilidade de um repositório e não publique em uma conta diferente sem autorização explícita.
5. Antes do commit, revise o diff completo e os nomes dos arquivos. Faça uma verificação de segredos para impedir o envio acidental de senhas, tokens, chaves, arquivos `.env`, dados pessoais ou dados reais de clientes.
6. Não force o push. Não use `git push --force`, `git reset --hard`, `git clean -fd` nem comandos destrutivos. Se houver conflitos, alterações locais inesperadas ou commits remotos divergentes, pare a operação arriscada e apresente o problema.

## 6. Validar o projeto antes de publicar

Execute apenas verificações compatíveis com a configuração real do repositório. Use, quando disponíveis:

- build de produção;
- lint e verificação de tipos;
- testes unitários e de integração;
- verificações existentes de links e rotas;
- testes do site nas versões claro e escuro, se esses temas existirem;
- teste de navegação e layout responsivo nas páginas principais;
- validação da demo do Mini ERP, caso esteja no workspace;
- verificação de que a demo não permite gravação de alterações, caso tenha sido especificada como somente para leitura.

Se alguma verificação falhar, investigue e corrija apenas o que estiver relacionado à tarefa e ao escopo autorizado. Repita os testes afetados após a correção. Não afirme que algo passou sem executar o teste. Se não for possível executar algum teste, registre a limitação com precisão.

## 7. Documentação do projeto

Respeite a convenção documental existente. Nos arquivos `README.md`, priorize documentação técnica profissional sobre:

- finalidade do sistema e funcionalidades reais;
- tecnologias utilizadas e sua função;
- arquitetura e organização dos diretórios;
- principais módulos e fluxo de dados;
- APIs utilizadas ou disponibilizadas, se aplicável;
- decisões técnicas relevantes e limitações conhecidas.

**Não transforme o README em tutorial de instalação**, conforme a orientação do projeto. Não invente funcionalidades, APIs, métricas, URLs, experiências, tecnologias ou resultados que não estejam presentes no código. Não remova informações válidas sem necessidade.

## 8. Commit e publicação no remoto

Depois de instalar o que for necessário, adicionar este documento e concluir as verificações:

1. Revise novamente `git status` e `git diff`.
2. Inclua somente os arquivos pertencentes a esta tarefa e as correções efetivamente aprovadas. Não inclua alterações pessoais não relacionadas.
3. Crie um commit com mensagem objetiva, por exemplo: `chore: preparar ambiente e documentar publicação`.
4. Faça push para a branch correta **somente se o remoto e a autorização estiverem confirmados**, e se não houver conflitos ou riscos de sobrescrever trabalho remoto.
5. Confirme o resultado do push pelo retorno do comando e, se disponível, verifique o último commit no remoto.
6. Se o usuário não forneceu o remoto, se não houver autenticação válida ou se a publicação exigir autorização, conclua as etapas locais possíveis e peça somente a informação ou ação que estiver faltando. Não diga que publicou quando apenas criou um commit local.

## 9. Critérios de conclusão

A tarefa só deve ser considerada concluída depois de verificar e relatar:

- [ ] O ambiente e as tecnologias reais foram identificados.
- [ ] As extensões escolhidas foram justificadas e instaladas ou sua instalação foi explicitamente marcada como pendente.
- [ ] As dependências necessárias foram verificadas sem atualização indiscriminada.
- [ ] Este arquivo foi adicionado à raiz do repositório correto.
- [ ] Foram revisados os arquivos preparados para commit e não há credenciais ou dados privados no conjunto de alterações.
- [ ] Build, lint e testes disponíveis foram executados, com resultados reais registrados.
- [ ] O commit local foi criado, caso não existam bloqueios.
- [ ] O push foi confirmado, ou o bloqueio para publicar foi informado com clareza.

## 10. Relatório final obrigatório

Ao terminar, apresente um resumo objetivo com:

- extensões instaladas e motivo de cada uma;
- ferramentas e dependências que foram instaladas ou já estavam disponíveis;
- caminho onde o arquivo foi salvo;
- verificações realizadas e resultados reais;
- arquivos alterados e motivo;
- hash e mensagem do commit, se criado;
- remoto e branch usados, sem revelar credenciais;
- confirmação explícita de push concluído ou não concluído;
- qualquer ação manual ou autorização ainda necessária.

Não exponha senhas, tokens ou chaves no relatório. Não declare que o site está publicado na web se apenas o código foi enviado para um repositório Git.
