<x-guest-layout>
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf
        <div>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                   class="block w-full border-gray-300 focus:border-black focus:ring-0 text-sm p-3 uppercase tracking-widest" 
                   placeholder="CORPORATE E-MAIL">
        </div>

        <div class="mt-4">
            <input id="password" type="password" name="password" required 
                   class="block w-full border-gray-300 focus:border-black focus:ring-0 text-sm p-3 uppercase tracking-widest" 
                   placeholder="PASSWORD">
        </div>

        <div class="flex items-center justify-between mt-6">
            <label class="inline-flex items-center text-xs text-gray-500 uppercase tracking-tighter">
                <input type="checkbox" class="rounded border-gray-300 text-black shadow-sm focus:ring-0" name="remember">
                <span class="ms-2">Beni Hatırla</span>
            </label>

            <button type="submit" class="bg-black text-white px-8 py-2 text-xs font-bold uppercase tracking-widest hover:bg-gray-800 transition">
                GİRİŞ YAP
            </button>
        </div>
    </form>
</x-guest-layout>