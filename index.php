<?php require_once "header.php"; ?>
<div class="container text-center">
    <div>
        <img class="img-fluid img-nav" src="src/img/rd.png" alt="RD Station Marketing">
    </div>
    <?php
    if (!$config['client_id'] || !$config['client_secret'] || !$config['callback']) {
        echo "<h1>É preciso criar uma um APP na plataforma RD Station.</h1>";
        exit();
    } else if (!$config['access_token'] || !$config['refresh_token']) {
        echo "<a href='https://api.rd.services/auth/dialog?client_id=" . $config['client_id'] . "&redirect_uri=" . $config['callback'] . "'>Click aqui para autenticar</a>";
    } else {
        ?>
        <div class="row">
            <div class="col"></div>
            <div class="col">
                <form id="cadastro" class="row g-3">
                    <div class="col-md-12">
                        <label for="inputEmail" class="form-label left">Email</label>
                        <input type="email" id="email" name="email" class="form-control" id="inputEmail"
                               placeholder="Email">
                    </div>
                    <div class="col-md-12">
                        <label for="tag" class="form-label">Tag</label>
                        <input type="text" class="form-control" id="tag" name="tag" placeholder="Tag">
                    </div>
                    <div class="col-md-12">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" id="price" name="price" class="form-control" id="price" placeholder="Price">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                    <br>
                    <div class="col-12">
                        <span name="" id="res"></span>
                    </div>
                </form>
            </div>
            <div class="col"></div>
        </div>
        <?php
    }
    ?>
</div>
<?php require_once "footer.php"; ?>
