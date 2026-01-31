    </main>
</div>
<script>
(function(){
    localStorage.setItem('isLoggedIn', '1');
    window.addEventListener('pageshow', function(e) {
        if (!localStorage.getItem('isLoggedIn') || e.persisted) {
            window.location.replace('../login.php');
        }
    });
})();
</script>
</body>
</html>
