<main class="container-pingserver">
    <!-- HEADER -->
    <header class="header-container">
        <?php
        $template = new PageBuilder();
        $template->module = "public";
        $template->folder = "template/view";
        $template->file = "header-page";
        echo $template->loudHTMLTemplate();
        ?>
    </header>
    <!-- BODY -->
    <section class="body-container">
        <?php
        $tempPinger = new PageBuilder();
        $tempPinger->module = "public";
        $tempPinger->folder = "template/view";
        $tempPinger->file = "tables-pingserver";
        echo $tempPinger->loudHTMLTemplate();
        ?>
    </section>
    <!-- FOOTER -->
    <footer class="footer-container"></footer>
</main>