<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800 tracking-tight">
            Ankete Katıl
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-8 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $survey->title }}</h3>
                @if($survey->description)
                    <p class="text-gray-600">{{ $survey->description }}</p>
                @endif
                <p class="text-xs text-gray-400 mt-4">
                    Bu anket toplam {{ $survey->questions->count() }} sorudan oluşmaktadır. Lütfen tüm soruları eksiksiz yanıtlayın.
                </p>
            </div>

            <form action="{{ route('surveys.submit', $survey) }}" method="POST" class="p-8 space-y-8">
                @csrf
                
                @foreach($survey->questions as $index => $question)
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm relative">
                        <div class="absolute -top-3 -left-3 w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold shadow-md">
                            {{ $index + 1 }}
                        </div>
                        
                        <h4 class="text-lg font-semibold text-gray-900 mb-4 ml-4">{{ $question->question_text }}</h4>

                        <div class="ml-4">
                            @if($question->type == 'text')
                                <textarea name="answers[{{ $question->id }}]" rows="3" class="input-field" placeholder="Cevabınızı buraya yazın..." required></textarea>
                            @elseif($question->type == 'choice' && is_array($question->options))
                                <div class="space-y-3">
                                    @foreach($question->options as $optIndex => $option)
                                        <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-indigo-50 hover:border-indigo-200 transition-colors">
                                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}" class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" required>
                                            <span class="ml-3 text-sm font-medium text-gray-700">{{ $option }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

                <div class="pt-6 border-t border-gray-100 flex items-center justify-between">
                    <a href="{{ route('surveys.index') }}" class="text-gray-500 hover:text-gray-700 font-medium text-sm">İptal Et ve Geri Dön</a>
                    <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold shadow-lg shadow-indigo-200 transition-all">
                        Anketi Tamamla
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
