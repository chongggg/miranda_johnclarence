<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Add New Student - Student Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        :root{
            /* MATCHED TO DASHBOARD */
            --background: linear-gradient(135deg, #1e3a8a 0%, #172554 55%, #000000 100%); /* blue-900 → blue-950 → black */
            --primary: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);                 /* blue-500 → indigo-600 */
            --secondary: linear-gradient(135deg, rgba(59,130,246,0.35), rgba(99,102,241,0.35)); /* soft blue/indigo blob */
            --accent: linear-gradient(135deg, rgba(59,130,246,0.25), rgba(99,102,241,0.25));    /* softer blob */
        }

        body{
            background: var(--background);
            min-height: 100vh;
            color:#fff; /* default light text */
        }

        .gradient-primary{ background: var(--primary); }
        .gradient-secondary{ background: var(--secondary); }
        .gradient-accent{ background: var(--accent); }

        /* Dark glass similar to your list page */
        .glass-card{
            background: rgba(255,255,255,0.10);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.20);
            box-shadow: 0 8px 32px rgba(0,0,0,0.35);
            color:#e5e7eb; /* gray-300 */
        }

        /* Inputs on dark: readable text, subtle borders, visible placeholders */
        input.glass-card{
            background: rgba(255,255,255,0.08);
            color:#fff;
            border-color: rgba(255,255,255,0.25);
        }
        input.glass-card::placeholder{ color: rgba(229,231,235,0.7); } /* gray-200/70 */

        .input-focus:focus{
            border-color:#3b82f6; /* blue-500 */
            box-shadow:0 0 0 3px rgba(59,130,246,0.25);
            outline:none;
        }

        .hover-scale:hover{ transform: scale(1.05); }
        .transition-all{ transition: all .3s ease; }

        /* Ensure all typical text elements stay light by default */
        label, h1, h2, p, span, a, .muted { color:#f9fafb; } /* near-white */

        /* Small helper for secondary text when needed */
        .text-subtle{ color:#d1d5db; } /* gray-300 */
    </style>
</head>
<body class="min-h-screen relative overflow-hidden text-white">
    <!-- Animated Background Shapes (now blue/indigo) -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 right-10 w-96 h-96 gradient-accent rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-[float_6s_ease-in-out_infinite]"></div>
        <div class="absolute bottom-10 left-10 w-96 h-96 gradient-secondary rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-[float_6s_ease-in-out_infinite] [animation-delay:3s]"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 gradient-primary rounded-full mix-blend-multiply filter blur-xl opacity-10 animate-[pulse_4s_cubic-bezier(0.4,0,0.6,1)_infinite]"></div>
    </div>

    <div class="container mx-auto p-8 max-w-4xl relative z-10">
        <!-- Header -->
        <div class="flex items-center gap-4 mb-8">
            <a href="/" class="rounded-xl border border-white/30 hover-scale transition-all glass-card px-4 py-2 inline-flex items-center gap-2 text-gray-100 hover:bg-white/10">
                <i data-lucide="arrow-left" class="h-5 w-5"></i>
                Back to Students
            </a>
            <div class="flex items-center gap-3">
                <div class="gradient-primary p-3 rounded-xl">
                    <i data-lucide="user-plus" class="h-6 w-6 text-white"></i>
                </div>
                <!-- Blue → Indigo gradient title to match dashboard hero -->
                <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-400 to-indigo-500 bg-clip-text text-transparent">
                    Add New Student
                </h1>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-8">
            <!-- Form Section -->
            <div class="glass-card rounded-2xl p-8 hover:shadow-2xl transition-all">
                <div class="flex items-center gap-3 mb-6">
                    <i data-lucide="sparkles" class="h-5 w-5 text-indigo-400"></i>
                    <h2 class="text-xl font-semibold">Student Information</h2>
                </div>

                <form method="POST" action="/students/store" class="space-y-6">
                    <div class="space-y-3">
                        <label for="first_name" class="flex items-center gap-2 text-base font-medium">
                            <i data-lucide="user" class="h-4 w-4 text-blue-400"></i>
                            First Name
                        </label>
                        <input
                            id="first_name"
                            name="first_name"
                            type="text"
                            required
                            class="w-full rounded-xl border input-focus h-12 px-4 glass-card transition-all"
                            placeholder="Enter first name"
                            oninput="updatePreview()"
                        />
                    </div>

                    <div class="space-y-3">
                        <label for="last_name" class="flex items-center gap-2 text-base font-medium">
                            <i data-lucide="user" class="h-4 w-4 text-indigo-400"></i>
                            Last Name
                        </label>
                        <input
                            id="last_name"
                            name="last_name"
                            type="text"
                            required
                            class="w-full rounded-xl border input-focus h-12 px-4 glass-card transition-all"
                            placeholder="Enter last name"
                            oninput="updatePreview()"
                        />
                    </div>

                    <div class="space-y-3">
                        <label for="email" class="flex items-center gap-2 text-base font-medium">
                            <i data-lucide="mail" class="h-4 w-4 text-blue-400"></i>
                            Email Address
                        </label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            required
                            class="w-full rounded-xl border input-focus h-12 px-4 glass-card transition-all"
                            placeholder="Enter email address"
                            oninput="updatePreview()"
                        />
                    </div>

                    <div class="flex gap-4 pt-6">
                        <button type="submit" class="flex-1 gradient-primary text-white border-0 rounded-xl h-12 hover-scale transition-all shadow-lg hover:shadow-xl inline-flex items-center justify-center gap-2">
                            <i data-lucide="save" class="h-5 w-5"></i>
                            Save Student
                        </button>
                        <a href="/" class="px-8 rounded-xl border border-white/30 hover-scale transition-all glass-card inline-flex items-center justify-center text-gray-100 hover:bg-white/10">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

            <!-- Preview Section -->
            <div class="glass-card rounded-2xl p-8 hover:shadow-2xl transition-all">
                <div class="flex items-center gap-3 mb-6">
                    <div class="gradient-primary p-2 rounded-lg">
                        <i data-lucide="user" class="h-4 w-4 text-white"></i>
                    </div>
                    <h2 class="text-xl font-semibold">Preview</h2>
                </div>

                <div class="space-y-4">
                    <div class="glass-card rounded-xl p-4 border-l-4" style="border-left-color:#60a5fa;"> <!-- blue-400 -->
                        <p class="text-sm text-subtle mb-1">Full Name</p>
                        <p class="font-semibold" id="preview-name">First Last</p>
                    </div>

                    <div class="glass-card rounded-xl p-4 border-l-4" style="border-left-color:#818cf8;"> <!-- indigo-400 -->
                        <p class="text-sm text-subtle mb-1">Email</p>
                        <p class="font-semibold" id="preview-email">email@example.com</p>
                    </div>

                    <div class="glass-card rounded-xl p-4 border-l-4" style="border-left-color:#34d399;"> <!-- green-400 -->
                        <p class="text-sm text-subtle mb-1">Status</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm" style="background: rgba(16,185,129,0.18); color:#86efac;">
                            Ready to Save
                        </span>
                    </div>
                </div>

                <!-- Pro tip box re-themed to blue/indigo -->
                <div class="mt-8 p-4 glass-card rounded-xl">
                    <div class="flex items-center gap-2 mb-2">
                        <i data-lucide="sparkles" class="h-4 w-4 text-indigo-400"></i>
                        <span class="text-sm font-medium">Pro Tip</span>
                    </div>
                    <p class="text-sm text-subtle">
                        Use a valid email address for notifications and updates.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
        function updatePreview(){
            const first = document.getElementById('first_name').value || 'First';
            const last  = document.getElementById('last_name').value  || 'Last';
            const email = document.getElementById('email').value      || 'email@example.com';
            document.getElementById('preview-name').textContent = first + ' ' + last;
            document.getElementById('preview-email').textContent = email;
        }
    </script>

    <!-- Minimal keyframes used above -->
    <style>
        @keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}
        @keyframes pulse{0%,100%{opacity:.6}50%{opacity:1}}
    </style>
</body>
</html>
