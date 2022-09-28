
    <script src="src/js/bootstrap.bundle.min.js"></script>
    <script src="src/js/popper.min.js"></script>
    <script src="src/js/bootstrap.min.js"></script>
    <script>
        $(function () {
            $("#cadastro").on("submit", function (e) {
                e.preventDefault();
                $.post("rdstation.php", $("#cadastro").serialize(),
                    function (data) {
                        $("#res").html(data);
                    }
                )
            })
        })
    </script>
</body>
</html>