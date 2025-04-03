@extends('layouts.app')

@section('register')
<div class="compact-login">
    <div class="card shadow-sm border-1">
        <div class="card-header bg-primary text-white text-center py-3">
            <h4 class="mb-0">
                <i class="fas fa-user-plus me-2"></i>
                Criar Nova Conta
            </h4>
        </div>

        <div class="card-body p-4">
            <form id="form" action="{{ route('register') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        placeholder="Informe seu nome"
                        required
                        autofocus
                        autocomplete="name"
                        value="{{ old('name') }}"
                    >
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        placeholder="Informe seu email"
                        required
                        autocomplete="email"
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
                        autocomplete="new-password"
                    >
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-control"
                        placeholder="Confirme sua senha"
                        required
                        autocomplete="new-password"
                    >
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="d-flex align-items-center justify-content-between mt-4">
                    <a href="{{ route('login') }}" class="text-decoration-none">
                        Já possui uma conta?
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-user-plus me-2"></i>
                        Registrar-se
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
