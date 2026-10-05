<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} &mdash; Gestione coorti per studi clinici</title>
    <meta name="description" content="Piattaforma per la gestione di coorti di pazienti per studi clinici, sviluppata nell'ambito del progetto ARCHIPREVALEAT.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <style>
        :root {
            --color-bg: #0b1220;
            --color-bg-soft: #101a2e;
            --color-accent: #f59e0b;
            --color-accent-soft: #fcd34d;
            --color-text: #e8ecf4;
            --color-text-muted: #9aa5b8;
            --color-border: rgba(255, 255, 255, 0.08);
        }

        @media (prefers-color-scheme: light) {
            :root {
                --color-bg: #f7f7f5;
                --color-bg-soft: #ffffff;
                --color-accent: #b45309;
                --color-accent-soft: #f59e0b;
                --color-text: #1b1b18;
                --color-text-muted: #6b6b64;
                --color-border: rgba(0, 0, 0, 0.08);
            }
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            background: radial-gradient(circle at top, var(--color-bg-soft), var(--color-bg));
            color: var(--color-text);
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
        }

        .card {
            width: 100%;
            max-width: 42rem;
            background: var(--color-bg-soft);
            border: 1px solid var(--color-border);
            border-radius: 1.25rem;
            padding: 2.75rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--color-accent-soft);
            margin-bottom: 1rem;
        }

        .eyebrow::before {
            content: '';
            width: 0.5rem;
            height: 0.5rem;
            border-radius: 999px;
            background: var(--color-accent);
        }

        h1 {
            margin: 0 0 0.75rem;
            font-size: clamp(1.75rem, 4vw, 2.25rem);
            line-height: 1.2;
        }

        p.lead {
            margin: 0 0 2rem;
            color: var(--color-text-muted);
            font-size: 1.05rem;
            line-height: 1.6;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.7rem 1.3rem;
            border-radius: 0.6rem;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            transition: opacity 0.15s ease, transform 0.15s ease;
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn-primary {
            background: var(--color-accent);
            color: #1b1105;
        }

        .btn-secondary {
            background: transparent;
            color: var(--color-text);
            border: 1px solid var(--color-border);
        }

        footer {
            margin-top: 2.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--color-border);
            font-size: 0.85rem;
            color: var(--color-text-muted);
        }

        footer a {
            color: inherit;
        }
    </style>
</head>
<body>
    <main class="card">
        <span class="eyebrow">Studio clinico &middot; Gestione coorti</span>
        <h1>{{ config('app.name') }}</h1>
        <p class="lead">
            Piattaforma per la raccolta e il monitoraggio dei dati di coorti di pazienti
            arruolati negli studi clinici, ad uso degli specialisti ricercatori del progetto
            <strong>ARCHIPREVALEAT</strong>.
        </p>
        <div class="actions">
            <a class="btn btn-primary" href="{{ url('/admin') }}">Accedi alla piattaforma</a>
            <a class="btn btn-secondary" href="https://www.archiprevaleat.com/" target="_blank" rel="noopener noreferrer">
                Scopri il progetto ARCHIPREVALEAT
            </a>
        </div>
        <footer>
            &copy; {{ date('Y') }} {{ config('app.name') }}.
            Maggiori informazioni sul progetto: <a href="https://www.archiprevaleat.com/" target="_blank" rel="noopener noreferrer">archiprevaleat.com</a>
        </footer>
    </main>
</body>
</html>
