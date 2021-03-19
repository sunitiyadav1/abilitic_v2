    <!-- START PLUGINS -->
    <script type="text/javascript" src="layout/assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="layout/assets/js/moment.min.js"></script>
    <script type="text/javascript" src="layout/assets/js/bootstrap/popper.min.js"></script>
    <script type="text/javascript" src="layout/assets/js/bootstrap/bootstrap.min.js"></script>
    <script type="text/javascript" src="layout/assets/js/zing-theme.js"></script>

    <script type="text/javascript" src="layout/assets/js/chart.min.js"></script>

    <script>
    function makeAjaxCall(url,data)
    {

        return $.ajax({
            url : url,
            method : 'POST',
            data:data,
            dataType : "json"
        })
    }
    </script>
</body>
</html>