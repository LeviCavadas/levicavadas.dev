# Instruções para o Claude Code — Botões de GitHub e LinkedIn

## Objetivo

Ajustar os botões de acesso ao GitHub e ao LinkedIn no portfólio **levicavadas.dev**. No estado normal, cada botão deve mostrar somente o símbolo da plataforma. Quando a pessoa passar o mouse por cima, o nome correspondente deve aparecer com uma transição discreta. A solução precisa manter a identidade visual do site, apresentar contraste adequado nos temas claro e escuro e funcionar bem em dispositivos móveis e com teclado.

Implemente as alterações diretamente no repositório existente. Não entregue apenas um plano ou exemplos isolados.

## 1. Inspecionar o projeto antes de alterar

1. Leia o `CLAUDE.md` e os demais documentos de especificação relevantes que existirem no repositório.
2. Identifique o componente, a página e os estilos responsáveis pelos links do GitHub e do LinkedIn.
3. Verifique qual biblioteca de ícones e qual solução de temas o projeto já utiliza. Reaproveite a arquitetura, os tokens de cores, os espaçamentos, as fontes, os raios de borda e os padrões de animação existentes.
4. Confira os destinos atuais dos links. Preserve os endereços corretos encontrados no projeto; não invente URLs, perfis ou repositórios. Se algum endereço estiver ausente, sinalize isso em vez de preencher com um link fictício.

## 2. Comportamento visual esperado

### Estado padrão

- Exibir apenas o símbolo reconhecível do GitHub e o símbolo reconhecível do LinkedIn.
- Manter os botões compactos, alinhados entre si e visualmente equilibrados.
- Usar uma área clicável confortável, com dimensões consistentes entre os dois botões.
- Evitar texto permanente que deixe a área visualmente carregada.

### Ao passar o mouse

- Revelar o rótulo “GitHub” ou “LinkedIn” associado ao respectivo ícone.
- Preferir uma expansão suave do botão ou uma dica visual bem posicionada, seguindo o estilo já usado no site. A animação deve ser rápida, discreta e sem deslocar bruscamente os elementos próximos.
- Não fazer o botão piscar, saltar, mudar de posição inesperadamente nem cobrir conteúdo importante.
- Manter o ícone visível depois que o rótulo aparecer.

### Teclado, toque e acessibilidade

- Quando o botão receber foco pelo teclado, mostrar o mesmo rótulo ou uma indicação equivalente à apresentada no hover.
- Cada link precisa de um nome acessível, por exemplo, `aria-label="GitHub"` e `aria-label="LinkedIn"`. O texto visual oculto inicialmente não pode tornar o link inacessível a leitores de tela.
- Garantir um indicador de foco visível e compatível com o design.
- Não depender exclusivamente do hover: em telas sensíveis ao toque, o link deve continuar óbvio e utilizável. O rótulo pode aparecer com foco ou ser disponibilizado por uma dica acessível, sem exigir que o usuário faça hover.
- Respeitar a preferência do sistema por redução de movimento (`prefers-reduced-motion`).

## 3. Cores e contraste com os temas

- Os botões devem se destacar do fundo do site tanto no tema claro quanto no tema escuro, sem parecer elementos estranhos à identidade visual.
- Use os tokens de tema e os padrões visuais já existentes. Não aplique uma cor fixa que desapareça ou perca contraste quando o tema for alterado.
- Priorize contraste suficiente entre ícone, rótulo e fundo; como referência, busque pelo menos 4,5:1 para texto normal e 3:1 para elementos gráficos essenciais e componentes de interface, conforme aplicável às recomendações WCAG.
- Pode usar as cores de marca do GitHub e do LinkedIn como detalhe, desde que o contraste e a estética geral continuem bons nos dois temas. Se as cores oficiais não funcionarem em determinado tema, use uma superfície e uma cor de ícone derivadas da paleta do próprio site.
- Defina estados consistentes para normal, hover, foco, pressionado e desabilitado, caso este último estado faça sentido no componente.
- Evite sombras excessivas, gradientes chamativos, contornos grossos ou cores neon que destoem do design atual.

## 4. Ícones e links

- Use ícones oficiais/reconhecíveis das plataformas, de preferência aproveitando a biblioteca já instalada no projeto.
- Se a biblioteca atual não oferecer símbolos adequados, crie ou utilize SVGs leves, acessíveis e compatíveis com a implementação existente. Não instale outra dependência sem necessidade.
- Garanta que o ícone do GitHub não seja confundido com um ícone genérico de terminal ou código e que o LinkedIn seja identificável.
- Preserve os destinos corretos dos links encontrados no projeto.
- Para links externos, mantenha o padrão de abertura já adotado no site. Se usar `target="_blank"`, inclua `rel="noopener noreferrer"`.
- Não transforme botões decorativos sem destino em links funcionais nem crie URLs fictícias para preencher lacunas.

## 5. Implementação e manutenção

- Faça a mudança no componente compartilhado, se os botões aparecerem em mais de uma seção, evitando duplicar código e estilos.
- Mantenha os estilos responsivos e reutilize variáveis CSS ou tokens de tema sempre que possível.
- Se o texto aparecer por expansão, garanta que o botão tenha largura suficiente sem causar quebra de linha, sobreposição ou alteração indevida do layout.
- Não reestruture outras partes do portfólio e não altere conteúdo não relacionado a esta tarefa.
- Preserve a consistência com o seletor de tema existente e com as regras de acessibilidade já implementadas.

## 6. Validação obrigatória

Depois de implementar:

1. Execute o build e os testes disponíveis no projeto.
2. Verifique os botões no tema claro e no tema escuro.
3. Confirme que o símbolo aparece sozinho no estado normal e que o nome certo aparece ao passar o mouse.
4. Confirme que o comportamento equivalente funciona com foco de teclado.
5. Teste em largura de desktop e em tela mobile, verificando que os botões não ficam cortados, sobrepostos ou difíceis de tocar.
6. Verifique os contrastes, o indicador de foco, os nomes acessíveis e o comportamento com redução de movimento.
7. Confira se ambos os links apontam para os destinos corretos.
8. Corrija os problemas encontrados e execute novamente os testes pertinentes.

## Critérios de aceite

A tarefa só deve ser considerada concluída quando:

- Os botões mostrarem apenas os ícones no estado padrão.
- O hover revelar “GitHub” e “LinkedIn” de maneira suave e esteticamente coerente.
- O foco de teclado fornecer uma experiência equivalente e acessível.
- As cores tiverem contraste adequado em ambos os temas.
- Os links estiverem corretos e funcionando.
- O layout continuar responsivo e o restante do site permanecer visualmente consistente.
- O build e os testes disponíveis tiverem sido executados, com os resultados reais informados.

## Relatório final

Ao terminar, informe de forma breve:

- quais arquivos foram modificados;
- como o hover, o foco e o comportamento mobile foram implementados;
- como foram tratadas as cores nos temas claro e escuro;
- quais comandos de build e teste foram executados e seus resultados;
- qualquer pendência real, sem afirmar que algo foi testado se não foi.
