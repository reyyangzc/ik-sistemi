<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Strategic Portal | Elite Edition</title>
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
            padding-top: 40px;
            padding-bottom: 80px;
        }

        /* ÜST BAŞLIK - GAZETE LOGOSU */
        .journal-header {
            text-align: center;
            border-bottom: 4px double var(--border-ink);
            padding-bottom: 25px;
            margin-bottom: 60px;
        }

        .journal-title {
            font-family: 'Playfair Display', serif;
            font-weight: 900;
            font-size: 4rem;
            letter-spacing: -1.5px;
            color: var(--ink-black);
            margin-bottom: 5px;
        }

        .journal-meta {
            font-family: 'Inter', sans-serif;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 2px;
            font-weight: 700;
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #d1cfc7;
        }

        /* CEO VE ŞİRKET BİLGİSİ */
        .ceo-label {
            font-family: 'Inter', sans-serif;
            font-size: 0.65rem;
            color: var(--sepia-gold);
            letter-spacing: 3px;
            margin-bottom: 40px;
            text-align: center;
        }

        /* MODERN KART - HEM GAZETE HEM INTERAKTIF */
        .task-card {
            background: #ffffff;
            border: 1px solid #e0ddd5;
            padding: 35px;
            margin-bottom: 30px;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
        }

        /* Mouse Üstüne Gelince Büyüme Efekti */
        .task-card:hover {
            transform: translateY(-12px) scale(1.01);
            box-shadow: 0 25px 50px rgba(0,0,0,0.08);
            border-color: var(--ink-black);
            z-index: 10;
        }

        .task-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
            line-height: 1.2;
        }

        .author-line {
            font-family: 'Inter', sans-serif;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--sepia-gold);
            margin-bottom: 25px;
            border-bottom: 1px solid #f0eee9;
            padding-bottom: 10px;
        }

        .description-text {
            font-size: 1rem;
            color: #333;
            margin-bottom: 30px;
        }

        /* İSTATİSTİK SAYILARI */
        .stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 900;
            display: block;
        }

        .btn-ink {
            background: var(--ink-black);
            color: white;
            border-radius: 0;
            font-family: 'Inter', sans-serif;
            font-size: 0.7rem;
            letter-spacing: 1.5px;
            font-weight: 700;
            padding: 12px;
            border: none;
            transition: 0.3s;
        }

        .btn-ink:hover {
            background: var(--ny-red);
            transform: translateY(-2px);
        }

        .comment-input {
            border: none;
            border-bottom: 1px solid #ccc;
            background: transparent;
            border-radius: 0;
            font-size: 0.8rem;
            padding: 5px 0;
        }

        .comment-input:focus {
            box-shadow: none;
            border-bottom: 1px solid var(--ink-black);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="ceo-label">CHIEF EXECUTIVE OFFICER: ŞERİFE ÇAKMAK — GLOBAL STRATEGY DIVISION</div>

    <div class="journal-header">
        <h1 class="journal-title">Strategic Human Resources</h1>
        <div class="journal-meta">
            <div class="text-center">
                <span class="stat-num">{{ $tasks->count() }}</span>
                <span>DOSYA HACMİ</span>
            </div>
            <div class="text-center">
                <span class="stat-num text-success">{{ $tasks->where('status', 'tamamlandi')->count() }}</span>
                <span>İCRA EDİLEN</span>
            </div>
            <div class="text-center text-warning">
                <span class="stat-num text-warning">{{ $tasks->where('status', 'yapilacak')->count() }}</span>
                <span>BEKLEMEDE</span>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach($tasks as $task)
        <div class="col-lg-10 offset-lg-1">
            <div class="task-card shadow-sm">
                <div class="row">
                    <div class="col-md-8">
                        <div class="author-line">Dosya No: #{{ $task->id }} — Sorumlu: {{ $task->assignee->name }}</div>
                        <h2 class="task-title">{{ $task->title }}</h2>
                        <p class="description-text">{{ $task->description }}</p>
                        
                        <div class="mt-4">
                            <h6 class="fw-bold small mb-3" style="font-family: 'Inter'; letter-spacing: 1px;">ALT SÜREÇ ANALİZİ</h6>
                            <div class="row">
                                @foreach($task->subTasks as $sub)
                                <div class="col-md-6 mb-2 small">
                                    <span style="color: {{ $sub->status == 'tamamlandi' ? 'green' : '#ccc' }}; font-size: 1.2rem; vertical-align: middle;">●</span> 
                                    <span class="ms-1">{{ $sub->title }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 border-start px-4">
                        <form action="{{ route('tasks.updateStatus', $task->id) }}" method="POST">
                            @csrf
                            <label class="small fw-bold mb-2" style="font-family: 'Inter';">AKSİYON PLANI</label>
                            <select name="status" class="form-select form-select-sm mb-3 rounded-0 border-dark shadow-none">
                                <option value="yapilacak" {{ $task->status == 'yapilacak' ? 'selected' : '' }}>Yapılacak</option>
                                <option value="devam_ediyor" {{ $task->status == 'devam_ediyor' ? 'selected' : '' }}>Devam Ediyor</option>
                                <option value="tamamlandi" {{ $task->status == 'tamamlandi' ? 'selected' : '' }}>Tamamlandı</option>
                            </select>
                            <button class="btn btn-ink w-100" type="submit">SÜRECİ ONAYLA</button>
                        </form>

                        <div class="mt-4">
                            <label class="small fw-bold mb-2" style="font-family: 'Inter';">KURUMSAL NOTLAR</label>
                            @foreach($task->comments as $comment)
                                <div class="small mb-2 pb-1 border-bottom border-light" style="font-family: 'Inter'; font-size: 0.75rem;">
                                    <strong>{{ $comment->user->name }}:</strong> {{ $comment->comment }}
                                </div>
                            @endforeach
                            <form action="{{ route('tasks.comments.store', $task->id) }}" method="POST">
                                @csrf
                                <input type="text" name="comment" class="form-control comment-input" placeholder="Not bırakın...">
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