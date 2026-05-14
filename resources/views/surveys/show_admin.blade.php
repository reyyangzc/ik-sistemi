<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('surveys.index') }}" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-3xl text-gray-800 tracking-tight">
                Anket Sonuçları: {{ $survey->title }}
            </h2>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h4 class="text-sm font-medium text-gray-500 mb-1">Toplam Katılım</h4>
            <div class="text-3xl font-bold text-indigo-600">{{ $survey->responses->groupBy('employee_id')->count() }}</div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h4 class="text-sm font-medium text-gray-500 mb-1">Soru Sayısı</h4>
            <div class="text-3xl font-bold text-gray-900">{{ $survey->questions->count() }}</div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 md:col-span-2">
            <h4 class="text-sm font-medium text-gray-500 mb-1">Açıklama</h4>
            <p class="text-sm text-gray-700 line-clamp-2">{{ $survey->description ?: 'Belirtilmedi' }}</p>
        </div>
    </div>

    <div class="space-y-6">
        @foreach($survey->questions as $index => $question)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-900">Soru {{ $index + 1 }}: {{ $question->question_text }}</h3>
                    <p class="text-xs text-gray-500 mt-1">Tipi: {{ $question->type == 'choice' ? 'Çoktan Seçmeli' : 'Açık Uçlu (Metin)' }}</p>
                </div>
                
                <div class="p-6">
                    @php
                        $questionResponses = $survey->responses->where('survey_question_id', $question->id);
                    @endphp

                    @if($question->type == 'choice')
                        @php
                            // Cevapları say
                            $counts = [];
                            foreach($question->options as $opt) {
                                $counts[$opt] = 0;
                            }
                            foreach($questionResponses as $resp) {
                                $ans = json_decode($resp->answer_text) ?? $resp->answer_text;
                                if(isset($counts[$ans])) {
                                    $counts[$ans]++;
                                } else {
                                    $counts[$ans] = 1; // Beklenmeyen cevap
                                }
                            }
                            $total = $questionResponses->count();
                        @endphp
                        
                        <div class="space-y-4">
                            @foreach($counts as $option => $count)
                                @php
                                    $percentage = $total > 0 ? round(($count / $total) * 100) : 0;
                                @endphp
                                <div>
                                    <div class="flex justify-between items-end mb-1">
                                        <span class="text-sm font-medium text-gray-700">{{ $option }}</span>
                                        <span class="text-sm font-bold text-gray-900">{{ $count }} kişi (%{{ $percentage }})</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    @else
                        <!-- Açık uçlu metin cevapları listele -->
                        @if($questionResponses->count() > 0)
                            <ul class="space-y-3 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                                @foreach($questionResponses as $resp)
                                    <li class="p-3 bg-gray-50 border border-gray-100 rounded-lg text-sm text-gray-700 italic">
                                        "{{ $resp->answer_text }}"
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500 text-sm">Henüz bu soruya verilmiş bir metin cevabı yok.</p>
                        @endif
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</x-app-layout>
