<?php
/* ============================================================
   Entonces LAB — envio do formulário de contato
   PHP puro (mail()). Validação mínima + honeypot anti-spam.
   NOTA: o envio depende do mail() do host (ver README.md).
   ============================================================ */
$form_status = null;              // 'ok' | 'erro' | null
$form_errors = array();
$form_values = array('nome' => '', 'email' => '', 'mensagem' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $honeypot = trim((string)($_POST['website'] ?? ''));
    $nome     = trim((string)($_POST['nome'] ?? ''));
    $email    = trim((string)($_POST['email'] ?? ''));
    $mensagem = trim((string)($_POST['mensagem'] ?? ''));

    $form_values = array('nome' => $nome, 'email' => $email, 'mensagem' => $mensagem);

    // Honeypot preenchido = bot -> descarta em silêncio (sem envio, sem mensagem)
    $is_bot = ($honeypot !== '');

    if (!$is_bot) {
        if (strlen($nome) < 2) {
            $form_errors[] = 'Informe seu nome.';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $form_errors[] = 'Informe um e-mail válido.';
        }
        if (strlen($mensagem) < 10) {
            $form_errors[] = 'Escreva uma mensagem com pelo menos 10 caracteres.';
        }
    }

    if (!$is_bot && empty($form_errors)) {
        // Remove quebras de linha para evitar header injection
        $nome_safe = str_replace(array("\r", "\n"), '', $nome);
        $email_safe = str_replace(array("\r", "\n"), '', $email);

        $para    = 'entonceslab@gmail.com';
        $assunto = 'Contato pelo site — ' . $nome_safe;
        $corpo   = "Nome: " . $nome_safe . "\n"
                 . "E-mail: " . $email_safe . "\n\n"
                 . "Mensagem:\n" . $mensagem . "\n";
        $headers = "From: site@entonceslab.com.br\r\n"
                 . "Reply-To: " . $email_safe . "\r\n"
                 . "Content-Type: text/plain; charset=UTF-8\r\n";

        $form_status = @mail($para, $assunto, $corpo, $headers) ? 'ok' : 'erro';
    } elseif (!$is_bot) {
        $form_status = 'erro';
    }
}

function e($v) { return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contato — Entonces LAB</title>
  <meta name="description" content="Fale com a Entonces LAB: entonceslab@gmail.com · 55 51 9770-3290 · Rua Ivo Janson, 36 — Partenon, Porto Alegre/RS.">
  <link rel="canonical" href="https://entonceslab.com.br/contato.php">
  <meta property="og:type" content="website">
  <meta property="og:locale" content="pt_BR">
  <meta property="og:site_name" content="Entonces LAB">
  <meta property="og:title" content="Contato — Entonces LAB">
  <meta property="og:description" content="Vamos começar um experimento? Conte o seu objetivo — a gente prepara a fórmula certa.">
  <meta property="og:url" content="https://entonceslab.com.br/contato.php">
  <meta property="og:image" content="https://entonceslab.com.br/assets/logo_entonces_01_verde.png">
  <meta name="theme-color" content="#2A1240">
  <link rel="icon" type="image/png" href="assets/logo_entonces_03_branco.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700&family=Sora:wght@600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>

  <!-- ============ HEADER ============ -->
  <header class="site-header">
    <div class="container header-inner">
      <a href="index.php" aria-label="Entonces LAB — página inicial">
        <img src="assets/logo_entonces_03_branco.png" alt="Logo Entonces LAB" class="logo-block logo-header">
      </a>
      <nav class="main-nav" aria-label="Navegação principal">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="servicos.php">Serviços</a></li>
          <li><a href="contato.php" aria-current="page">Contato</a></li>
        </ul>
        <div class="nav-cta">
          <a href="contato.php" class="btn btn-accent">Solicitar orçamento<span class="arrow" aria-hidden="true">→</span></a>
        </div>
      </nav>
      <button class="nav-toggle" aria-expanded="false" aria-controls="menu" aria-label="Abrir menu">
        <span></span><span></span><span></span>
      </button>
    </div>
  </header>

  <main id="conteudo">

    <!-- ============ HERO COMPACTO ============ -->
    <section class="page-hero" aria-labelledby="pag-titulo">
      <span class="deco d1" aria-hidden="true"></span>
      <span class="deco d2" aria-hidden="true"></span>
      <div class="container">
        <p class="eyebrow">Contato</p>
        <h1 id="pag-titulo">Vamos começar um experimento?</h1>
        <p>Conte o seu objetivo — a gente prepara a fórmula certa. Atendemos Porto Alegre e todo o Brasil.</p>
      </div>
    </section>

    <!-- ============ CONTATO ============ -->
    <section class="section section-white" aria-labelledby="contato-titulo">
      <div class="container contato-grid">

        <div>
          <p class="eyebrow">Canais diretos</p>
          <h2 class="section-title" id="contato-titulo">Fale com quem faz</h2>
          <div class="contato-cards">
            <div class="contato-card reveal">
              <span class="ico" aria-hidden="true">@</span>
              <div>
                <h3>E-mail</h3>
                <p><a href="mailto:entonceslab@gmail.com">entonceslab@gmail.com</a></p>
              </div>
            </div>
            <div class="contato-card reveal" data-delay="70">
              <span class="ico" aria-hidden="true">✆</span>
              <div>
                <h3>Telefone / WhatsApp</h3>
                <p><a href="https://wa.me/555197703290?text=Ol%C3%A1%2C%20vim%20atrav%C3%A9s%20do%20site%20e%20gostaria%20de%20um%20or%C3%A7amento" target="_blank" rel="noopener">55 51 9770-3290</a></p>
                <p>Diogo Retamal</p>
              </div>
            </div>
            <div class="contato-card reveal" data-delay="140">
              <span class="ico" aria-hidden="true">⌖</span>
              <div>
                <h3>Endereço</h3>
                <p>Rua Ivo Janson, 36 — Partenon<br>Porto Alegre/RS</p>
              </div>
            </div>
          </div>
        </div>

        <div class="form-card reveal">
          <h2>Envie sua mensagem</h2>
          <p>Respondemos normalmente em até 1 dia útil.</p>

          <?php if ($form_status === 'ok'): ?>
            <p class="form-msg form-ok" role="status">Mensagem enviada com sucesso! Retornaremos em breve.</p>
          <?php elseif ($form_status === 'erro' && !empty($form_errors)): ?>
            <div class="form-msg form-err" role="alert">
              <strong>Não foi possível enviar:</strong>
              <ul>
                <?php foreach ($form_errors as $err): ?>
                  <li><?php echo e($err); ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php elseif ($form_status === 'erro'): ?>
            <p class="form-msg form-err" role="alert">Falha no envio. Tente novamente ou fale direto pelo WhatsApp 55 51 9770-3290.</p>
          <?php endif; ?>

          <form action="contato.php" method="post" novalidate>
            <div class="field">
              <label for="nome">Nome</label>
              <input type="text" id="nome" name="nome" placeholder="Seu nome" autocomplete="name" required value="<?php echo e($form_values['nome']); ?>">
            </div>
            <div class="field">
              <label for="email">E-mail</label>
              <input type="email" id="email" name="email" placeholder="voce@empresa.com.br" autocomplete="email" required value="<?php echo e($form_values['email']); ?>">
            </div>
            <div class="field">
              <label for="mensagem">Mensagem</label>
              <textarea id="mensagem" name="mensagem" placeholder="Conte o que você precisa…" required><?php echo e($form_values['mensagem']); ?></textarea>
            </div>
            <!-- Honeypot anti-spam: invisível para humanos -->
            <div class="hp-field" aria-hidden="true">
              <label for="website">Não preencha este campo</label>
              <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
            </div>
            <button type="submit" class="btn btn-primary">Enviar mensagem<span class="arrow" aria-hidden="true">→</span></button>
            <p class="form-note">Seus dados são usados apenas para retornar o seu contato.</p>
          </form>
        </div>

      </div>
    </section>

    <!-- ============ CTA FINAL ============ -->
    <section class="cta-final" aria-labelledby="cta-titulo">
      <span class="deco-circle c1" aria-hidden="true"></span>
      <span class="deco-circle c2" aria-hidden="true"></span>
      <img src="assets/logo_entonces_01_verde.png" alt="" class="deco-logo" aria-hidden="true">
      <div class="container">
        <h2 id="cta-titulo">Prefere conversar agora?</h2>
        <p class="cta-sub">Chame no WhatsApp — resposta rápida pelo 55 51 9770-3290.</p>
        <div class="cta-actions">
          <a href="https://wa.me/555197703290?text=Ol%C3%A1%2C%20vim%20atrav%C3%A9s%20do%20site%20e%20gostaria%20de%20um%20or%C3%A7amento" class="btn btn-primary" target="_blank" rel="noopener">Chamar no WhatsApp<span class="arrow" aria-hidden="true">→</span></a>
        </div>
        <p class="cta-note">ou escreva para entonceslab@gmail.com</p>
      </div>
    </section>

  </main>

  <!-- ============ FOOTER ============ -->
  <footer class="site-footer">
    <div class="container footer-grid">
      <div class="footer-brand">
        <img src="assets/logo_entonces_04_preto.png" alt="Logo Entonces LAB" class="logo-block logo-footer">
        <p>Somos especialistas em comunicação, conteúdo, planejamento, produção, marcas e resultados.</p>
      </div>
      <nav class="footer-col" aria-label="Navegação do rodapé">
        <h3>Navegação</h3>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="servicos.php">Serviços</a></li>
          <li><a href="contato.php">Contato</a></li>
        </ul>
      </nav>
      <div class="footer-col">
        <h3>Contato</h3>
        <address>
          <strong>Diogo Retamal</strong>
          <a href="mailto:entonceslab@gmail.com">entonceslab@gmail.com</a><br>
          <a href="tel:+555197703290">55 51 9770-3290</a><br>
          Rua Ivo Janson, 36 — Partenon<br>
          Porto Alegre/RS
        </address>
      </div>
      <span class="footer-exp" aria-hidden="true">EXP. 999<br>FIM DA PÁGINA</span>
    </div>
    <div class="container footer-bottom">
      <span>© <span data-year>2026</span> Entonces LAB. Todos os direitos reservados.</span>
      <span>então… vamos conversar?</span>
    </div>
  </footer>

  <script src="js/main.js"></script>
</body>
</html>
