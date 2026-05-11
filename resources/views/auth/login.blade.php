<x-guest-layout>
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf
        
        <div>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                   class="block w-full border-gray-300 focus:border-black focus:ring-0 text-sm p-3 tracking-widest lowercase text-gray-600" 
                   placeholder="E-posta adresi">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <input id="password" type="password" name="password" required 
                   class="block w-full border-gray-300 focus:border-black focus:ring-0 text-sm p-3 tracking-widest text-gray-600" 
                   placeholder="Şifre">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <label class="inline-flex items-center text-[10px] text-gray-400 uppercase tracking-widest cursor-pointer hover:text-gray-600 transition">
                <input type="checkbox" class="rounded-none border-gray-300 text-black shadow-sm focus:ring-0" name="remember">
                <span class="ms-2">Beni Hatırla</span>
            </label>

            <button type="submit" class="bg-black text-white px-10 py-3 text-[10px] font-black uppercase tracking-[0.2em] hover:bg-gray-800 transition duration-300 shadow-lg">
                GİRİŞ YAP
            </button>
        </div>

        @if (Route::has('password.request'))
            <div class="text-center mt-8">
                <a class="text-[9px] uppercase tracking-widest text-gray-400 hover:text-black transition" href="{{ route('password.request') }}">
                    Şifrenizi mi unuttunuz?
                </a>
            </div>
        @endif
    </form>
</x-guest-layout>