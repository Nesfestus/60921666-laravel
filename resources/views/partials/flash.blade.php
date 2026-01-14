<div class="container mt-3">

    {{-- Ошибки валидации полей email/password --}}
    @error('email')
    <div class="alert alert-warning">{{ $message }}</div>
    @enderror

    @error('password')
    <div class="alert alert-warning">{{ $message }}</div>
    @enderror

    {{-- Ошибка аутентификации --}}
    @error('error')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    {{-- Успешные сообщения (если будешь делать) --}}
    @error('success')
    <div class="alert alert-success">{{ $message }}</div>
    @enderror

    {{-- Сообщение от Gate / удаления / других действий --}}
    @if(session('message'))
        <div class="alert alert-info">{{ session('message') }}</div>
    @endif
</div>
