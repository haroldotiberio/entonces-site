# Entonces LAB — Implementação (07-implementation/source)

Site institucional final da Entonces LAB. **PHP puro + HTML/CSS/JS, sem frameworks**
(SEM WordPress, SEM Laravel). Implementação 1:1 do protótipo aprovado em
`06-prototypes/` (13/Ago/2026).

## Stack e requisitos

- PHP >= 8.2 (testado com 8.4) — sintaxe segura, sem short tags
- HTML5 semântico + CSS puro + JS vanilla (sem bibliotecas além do Google Fonts)
- Google Fonts: Sora (display) + Manrope (corpo), com `preconnect`

## Estrutura

```
source/
├── index.php              # Home (hero, quem somos, 9 serviços, clientes, CTA)
├── servicos.php           # Serviços (9 especialidades) + processo
├── contato.php            # Contato + formulário funcional (PHP mail())
├── css/styles.css         # VERSÃO EDITÁVEL (protótipo + regras do form)
├── js/main.js             # VERSÃO EDITÁVEL (menu mobile + reveal on scroll)
├── assets/                # VERSÃO EDITÁVEL (cópias dos assets aprovados)
│   ├── logo_entonces_0{1,2,3,4}.png
│   ├── collage_flor.png / collage_megafone.png
│   └── cliente_01..06.png
└── original/              # IMUTÁVEL — cópias byte-idênticas do protótipo aprovado
    ├── css/styles.css     #   (referência de design; não editar)
    ├── js/main.js
    └── assets/            #   (todos os assets originais)
```

### Regra de versões (briefing)

- `original/` isola os arquivos **imutáveis** (byte-idênticos a `06-prototypes/`):
  serve como referência/lock do design aprovado e base para diff em revisões.
- As versões **editáveis** ficam na raiz (`css/`, `js/`, `assets/`) e são as que
  as páginas referenciam — é onde ajustes futuros de implementação devem ocorrer.
- Verificação de integridade: `cmp -s 06-prototypes/css/styles.css source/original/css/styles.css`

## Links relativos

Todos os links do site são relativos (`css/styles.css`, `assets/...`, `index.php`,
`contato.php`…) — o site funciona em subdiretório no FTP sem ajustes.
As únicas URLs absolutas são: canonical/OG (SEO — exigem URL absoluta),
Google Fonts e `wa.me`/`mailto`/`tel`.

## Contato único

- WhatsApp/telefone: **55 51 9770-3290** (único número, em todas as páginas)
- Links `wa.me/555197703290` com texto pré-preenchido
  "Olá, vim através do site e gostaria de um orçamento"
- E-mail: entonceslab@gmail.com · Endereço: Rua Ivo Janson, 36 — Partenon, Porto Alegre/RS

## Formulário de contato (contato.php)

- **Envio:** `mail()` do PHP para `entonceslab@gmail.com` (From `site@entonceslab.com.br`,
  Reply-To do visitante, charset UTF-8).
- **Validação server-side:** nome >= 2 chars, e-mail via `FILTER_VALIDATE_EMAIL`,
  mensagem >= 10 chars; `htmlspecialchars` em todo echo; remoção de `\r\n`
  (anti header-injection).
- **Anti-spam:** honeypot invisível (`name="website"`); preenchido = descartado
  silenciosamente.
- **Limitação:** o envio depende de um MTA/serviço de e-mail no host (mail()).
  Em hosts compartilhados (cPanel/Plesk) normalmente funciona; se o host exigir
  SMTP autenticado, trocar a chamada `mail()` por PHPMailer/SMTP **somente** no
  bloco marcado no topo de `contato.php` — o resto do site não muda.

## SEO

- `title` + `meta description` + canonical + Open Graph por página
- `lang="pt-BR"`, um único `<h1>` por página, semântica
  (`header/nav/main/section/footer`)
- `theme-color`, favicon, `loading="lazy"` nas imagens de cliente

## Acessibilidade

- `alt` descritivo nas imagens; decorativas com `alt=""` + `aria-hidden`
- `label` em todos os inputs; `required` + validação server-side
- Contraste mantido (tokens do DESIGN.md), `prefers-reduced-motion` respeitado

## Deploy

Deploy é fase posterior (`09-deploy/`, outro perfil — FTP ftp.dartcom.com.br).
Enviar o conteúdo de `source/` para o document root mantendo a hierarquia
(ou o subdiretório combinado — links relativos garantem funcionamento).

## Evidências

Screenshots da implementação: `08-tests-evidence/screenshots-implementation/`
(gerados por `08-tests-evidence/scripts/shot_entonces_impl.py`).
