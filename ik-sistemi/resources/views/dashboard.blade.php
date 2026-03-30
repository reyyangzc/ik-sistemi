<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RAK | Global Strategic Systems</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Libre+Baskerville:wght@400;700&family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-paper: #faf9f6;
            --ink-black: #1a1a1a;
            --ny-red: #8b0000;
            --sepia-gold: #7d6348;
            --border-ink: #2c2c2c;
        }

        body { 
            background-color: var(--bg-paper); 
            color: var(--ink-black);
            font-family: 'Libre Baskerville', serif;
            padding-top: 20px;
            padding-bottom: 80px;
        }

        .auth-bar {
            font-family: 'Inter', sans-serif;
            font-size: 0.7rem;
            letter-spacing: 2px;
            border-bottom: 1px solid #e0ddd5;
            padding-bottom: 10px;
            margin-bottom: 30px;
            text-transform: uppercase;
        }

        .journal-header {
            text-align: center;
            border-bottom: 4px double var(--border-ink);
            padding-bottom: 25px;
            margin-bottom: 60px;
        }

        .journal-title {
            font-family: 'Playfair Display', serif;
            font-weight: 900;
            font-size: 5rem;
            letter-spacing: -3px;
            color: var(--ink-black);
            margin-bottom: 5px;
        }

        .journal-meta {
            font-family: 'Inter', sans-serif;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 3px;
            font-weight: 700;
            display: flex;
            justify-content: center;
            gap: 60px;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #d1cfc7;
        }

        .ceo-label {
            font-family: 'Inter', sans-serif;
            font-size: 0.7rem;
            color: var(--sepia-gold);
            letter-spacing: 4px;
            margin-bottom: 40px;
            text-align: center;
            font-weight: 600;
        }

        .task-card {
            background: #ffffff;
            border: 1px solid #e0ddd5;
            padding: 45px;
            margin-bottom: 40px;
            transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .task-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 30px 60px rgba(0,0,0,0.07);
            border-color: var(--ink-black);
        }

        .task-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 15px;
            line-height: 1.1;
        }

        .author-line {
            font-family: 'Inter', sans-serif;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--sepia-gold);
            margin-bottom: 30px;
            border-bottom: 1px solid #f0eee9;
            padding-bottom: 12px;
            font-weight: 700;
        }

        .label-style {
            font-family: 'Inter', sans-serif;
            font-size: 0.65rem;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #888;
            margin-bottom: 15px;
            display: block;
        }

        .btn-ink {
            background: var(--ink-black);
            color: white;
            border-radius: 0;
            font-family: 'Inter', sans-serif;
            font-size: 0.75rem;
            letter-spacing: 2px;
            font-weight: 700;
            padding: 15px;
            border: none;
            transition: 0.3s;
        }

        .btn-ink:hover { background: var(--ny-red); transform: scale(1.02); }

        .comment-input {
            border: none;
            border-bottom: 1px solid #d1cfc7;
            background: transparent;
            font-size: 0.85rem;
            padding: 10px 0;
            font-style: italic;
        }

        .subtask-dot {
            font-size: 0.6rem;
            vertical-align: middle;
            margin-right: 8px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="auth-bar d-flex justify-content-between align-items-center">
        <div>AKTİF OPERASYONEL YETKİ: <strong>{{ auth()->user()->name }}</strong></div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-link p-0 text-dark text-decoration-none fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">
                — OTURUMU GÜVENLİ SONLANDIR
            </button>
        </form>
    </div>

    <div class="ceo-label">CEO: ŞERİFE ÇAKMAK — CSO: İBRAHİM UĞUR YILMAZ — RAK GLOBAL STRATEGY DIVISION</div>

    <div class="journal-header">
        <h1 class="journal-title">RAK STRATEGIC</h1>
        <div class="journal-meta">
            <div class="text-center">
                <span style="font-family: 'Playfair Display'; font-size: 2.2rem; font-weight: 900; display: block;">{{ $tasks->count() }}</span>
                <span>DOSYA HACMİ</span>
            </div>
            <div class="text-center text-success">
                <span style="font-family: 'Playfair Display'; font-size: 2.2rem; font-weight: 900; display: block;">{{ $tasks->where('status', 'tamamlandi')->count() }}</span>
                <span>İCRA EDİLEN</span>
            </div>
            <div class="text-center text-warning">
                <span style="font-family: 'Playfair Display'; font-size: 2.2rem; font-weight: 900; display: block;">{{ $tasks->where('status', 'yapilacak')->count() }}</span>
                <span>BEKLEMEDE</span>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach($tasks as $task)
        <div class="col-lg-10 offset-lg-1">
            <div class="task-card">
                <div class="row">
                    <div class="col-md-8">
                        <div class="author-line">
                            PROTOKOL: RAK-2026-{{ str_pad($task->id, 3, '0', STR_PAD_LEFT) }} 
                            <span class="mx-3">|</span> 
                            İCRA MERCİİ: {{ $task->assignee->name }}
                        </div>
                        <h2 class="task-title">{{ $task->title }}</h2>
                        <p style="line-height: 1.8; text-align: justify; font-size: 1.05rem;">{{ $task->description }}</p>
                        
                        <div class="mt-5">
                            <span class="label-style">OPERASYONEL KATMAN ANALİZİ</span>
                            <div class="row">
                                @foreach($task->subTasks as $sub)
                                <div class="col-md-6 mb-3 small">
                                    <span class="subtask-dot" style="color: {{ $sub->status == 'tamamlandi' ? 'green' : '#ccc' }};">●</span> 
                                    <span style="font-family: 'Inter'; font-weight: 500;">{{ $sub->title }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 border-start px-5">
                        <form action="{{ route('tasks.updateStatus', $task->id) }}" method="POST">
                            @csrf
                            <span class="label-style">STRATEJİK YÖNELİM TERCİHİ</span>
                            <select name="status" class="form-select form-select-sm mb-4 rounded-0 border-dark shadow-none" style="font-family: 'Inter'; font-size: 0.8rem;">
                                <option value="yapilacak" {{ $task->status == 'yapilacak' ? 'selected' : '' }}>BEKLEMEDE (YAPILACAK)</option>
                                <option value="devam_ediyor" {{ $task->status == 'devam_ediyor' ? 'selected' : '' }}>İCRA SÜRECİNDE</option>
                                <option value="tamamlandi" {{ $task->status == 'tamamlandi' ? 'selected' : '' }}>TAMAMLANDI (ARŞİV)</option>
                            </select>
                            <button class="btn btn-ink w-100" type="submit">İCRAYI TASDİK ET</button>
                        </form>

                        <div class="mt-5">
                            <span class="label-style">YÖNETSEL ŞERHLER VE MÜLAHAZALAR</span>
                            <div class="mb-4">
                                @foreach($task->comments as $comment)
                                    <div class="small mb-3 pb-2 border-bottom border-light">
                                        <div style="font-family: 'Inter'; font-weight: 800; font-size: 0.65rem; color: var(--sepia-gold); text-transform: uppercase;">
                                            {{ $comment->user->name }}
                                        </div>
                                        <div style="font-family: 'Inter'; font-weight: 400; line-height: 1.4;">
                                            {{ $comment->comment }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <form action="{{ route('tasks.comments.store', $task->id) }}" method="POST">
                                @csrf
                                <input type="text" name="comment" class="form-control comment-input shadow-none" placeholder="Kurumsal mülahaza ekleyin...">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

</body>
</html>