<footer class="footer-custom py-3 mt-auto">
    <div class="container-fluid text-center">
        <small class="text-muted">
            &copy; {{ now()->year }} Restaurante - Todos os direitos reservados
        </small>

        @auth
        <div class="mt-2">
            <small class="text-muted">
                Versão 1.0
            </small>
        </div>
        @endauth
    </div>
</footer>
