@extends('layouts.app')

@section('login')
<div class="compact-login">
    <div class="card shadow-sm border-1">
        <div class="card-header bg-dark text-white text-center py-3">
            <h4 class="mb-0">
                <i class="fas fa-sign-in-alt me-2"></i>
                Acesso ao Sistema
            </h4>
        </div>

        <div class="card-body p-4">
            <form id="form" action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        placeholder="Informe seu email"
                        required
                        autofocus
                        value="{{ old('email') }}"
                    >
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        placeholder="Informe sua senha"
                        required
                        autocomplete="current-password"
                    >
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        Entrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
