<?php
// This view is called by StudentsController->edit($id)
// $student data is passed from the controller
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student - Student Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <style>
        :root{
            /* MATCHED DASHBOARD PALETTE */
            --background: linear-gradient(135deg, #1e3a8a 0%, #172554 55%, #000000 100%); /* blue-900 -> blue-950 -> black */
            --primary: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%); /* blue-500 -> indigo-600 */
            --blob: linear-gradient(135deg, rgba(59,130,246,0.28), rgba(99,102,241,0.24));
        }

        /* Page base */
        body{
            background: var(--background);
            min-height: 100vh;
            color: #fff;
            -webkit-font-smoothing:antialiased;
            -moz-osx-font-smoothing:grayscale;
        }

        /* Gradients */
        .gradient-primary{ background: var(--primary); }
        .gradient-secondary{ background: var(--blob); }

        /* Glass cards tuned for dark background */
        .glass-card{
            background: rgba(255,255,255,0.06);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.08);
            box-shadow: 0 10px 30px rgba(0,0,0,0.6);
            color: #e5e7eb; /* gray-200 */
        }

        /* Inputs for dark theme */
        .glass-input {
            background: rgba(255,255,255,0.03);
            color: #fff;
            border: 1px solid rgba(255,255,255,0.12);
            caret-color: #93c5fd;
        }
        .glass-input::placeholder {
            color: rgba(255,255,255,0.60);
        }

        .input-focus:focus{
            border-color: #3b82f6; /* blue-500 */
            box-shadow: 0 0 0 4px rgba(59,130,246,0.18);
            outline: none;
        }

        /* Force main text elements to be light */
        label, h1, h2, h3, p, span, a, .muted {
            color: #f8fafc !important; /* near-white */
        }

        /* subtle text for descriptions */
        .text-subtle { color: #d1d5db !important; } /* light gray for secondary text */

        /* Badge variants */
        .badge-default { background: rgba(255,255,255,0.06); color: #e5e7eb; }
        .badge-blue { background: rgba(59,130,246,0.18); color: #bfdbfe; }
        .badge-green { background: rgba(16,185,129,0.16); color: #bbf7d0; }
        .badge-orange { background: rgba(249,115,22,0.16); color: #ffd8b5; }

        /* Buttons */
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        .btn-glass {
            background: rgba(255,255,255,0.04);
            color: #fff;
            border: 1px solid rgba(255,255,255,0.08);
        }

        /* small helpers */
        .hover-scale:hover { transform: scale(1.03); }
        .transition-all { transition: all .25s ease; }

        @keyframes float { 0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)} }
        @keyframes pulse { 0%,100%{opacity:.7}50%{opacity:1} }
    </style>
</head>
<body class="min-h-screen relative overflow-hidden text-white">

    <!-- animated blobs (blue/indigo) -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-16 w-80 h-80 gradient-secondary rounded-full mix-blend-multiply filter blur-xl opacity-24 animate-[float_6s_ease-in-out_infinite]"></div>
        <div class="absolute bottom-20 right-16 w-80 h-80 gradient-primary rounded-full mix-blend-multiply filter blur-xl opacity-18 animate-[float_6s_ease-in-out_infinite]"></div>
        <div class="absolute top-1/3 right-1/3 w-72 h-72 gradient-secondary rounded-full mix-blend-multiply filter blur-2xl opacity-12 animate-[pulse_4s_cubic-bezier(0.4,0,0.6,1)_infinite]"></div>
    </div>

    <div class="container mx-auto p-8 max-w-4xl relative z-10">
        <!-- Header -->
        <div class="flex items-start gap-4 mb-8">
            <a href="/" class="rounded-xl border border-white/20 hover-scale transition-all glass-card px-4 py-2 inline-flex items-center gap-2 text-white hover:bg-white/6">
                <i data-lucide="arrow-left" class="h-5 w-5"></i>
                Back to Students
            </a>

            <div class="flex items-center gap-3">
                <div class="gradient-primary p-3 rounded-xl shadow-sm">
                    <i data-lucide="edit-3" class="h-6 w-6 text-white"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-400 to-indigo-500 bg-clip-text text-transparent">
                        Edit Student
                    </h1>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-white/10 text-white mt-1">
                        <i data-lucide="hash" class="h-3 w-3 mr-1"></i>
                        ID: <?= $student['id'] ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-8">
            <!-- Form Section -->
            <div class="glass-card rounded-2xl p-8 hover:shadow-2xl transition-all">
                <div class="flex items-center gap-3 mb-6">
                    <i data-lucide="edit-3" class="h-5 w-5 text-blue-300"></i>
                    <h2 class="text-xl font-semibold">Update Information</h2>
                    <span id="modified-badge" class="hidden inline-flex items-center px-3 py-1 rounded-full text-sm badge-orange ml-3">
                        Modified
                    </span>
                </div>

                <form method="POST" action="/students/update/<?= $student['id'] ?>" class="space-y-6">
                    <div class="space-y-3">
                        <label for="first_name" class="flex items-center gap-2 text-base font-medium">
                            <i data-lucide="user" class="h-4 w-4 text-blue-300"></i>
                            First Name
                        </label>
                        <input
                            id="first_name"
                            name="first_name"
                            type="text"
                            value="<?= htmlspecialchars($student['first_name']) ?>"
                            required
                            data-original="<?= htmlspecialchars($student['first_name']) ?>"
                            oninput="checkChanges()"
                            class="w-full rounded-xl glass-input h-12 px-4 transition-all input-focus"
                            placeholder="Enter first name"
                        />
                    </div>

                    <div class="space-y-3">
                        <label for="last_name" class="flex items-center gap-2 text-base font-medium">
                            <i data-lucide="user" class="h-4 w-4 text-indigo-300"></i>
                            Last Name
                        </label>
                        <input
                            id="last_name"
                            name="last_name"
                            type="text"
                            value="<?= htmlspecialchars($student['last_name']) ?>"
                            required
                            data-original="<?= htmlspecialchars($student['last_name']) ?>"
                            oninput="checkChanges()"
                            class="w-full rounded-xl glass-input h-12 px-4 transition-all input-focus"
                            placeholder="Enter last name"
                        />
                    </div>

                    <div class="space-y-3">
                        <label for="email" class="flex items-center gap-2 text-base font-medium">
                            <i data-lucide="mail" class="h-4 w-4 text-blue-300"></i>
                            Email Address
                        </label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="<?= htmlspecialchars($student['email']) ?>"
                            required
                            data-original="<?= htmlspecialchars($student['email']) ?>"
                            oninput="checkChanges()"
                            class="w-full rounded-xl glass-input h-12 px-4 transition-all input-focus"
                            placeholder="Enter email address"
                        />
                    </div>

                    <div class="flex gap-4 pt-6">
                        <button type="submit" id="update-btn" disabled
                                class="flex-1 btn-primary rounded-xl h-12 hover-scale transition-all shadow-lg inline-flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                            <i data-lucide="save" class="h-5 w-5"></i>
                            Update Student
                        </button>

                        <a href="/" class="px-8 rounded-xl btn-glass hover-scale transition-all inline-flex items-center justify-center text-white">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

            <!-- Preview / Right Column -->
            <div class="space-y-6">
                <!-- Current vs Updated -->
                <div class="glass-card rounded-2xl p-6 hover:shadow-2xl transition-all">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="gradient-primary p-2 rounded-lg">
                            <i data-lucide="user-check" class="h-4 w-4 text-white"></i>
                        </div>
                        <h2 class="text-lg font-semibold">Current vs Updated</h2>
                    </div>

                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="glass-card rounded-lg p-3">
                                <p class="text-xs text-subtle mb-1">Current Name</p>
                                <p class="font-medium text-sm" id="current-name"><?= htmlspecialchars($student['first_name']) ?> <?= htmlspecialchars($student['last_name']) ?></p>
                            </div>
                            <div class="glass-card rounded-lg p-3">
                                <p class="text-xs text-subtle mb-1">Updated Name</p>
                                <p class="font-medium text-sm" id="updated-name"><?= htmlspecialchars($student['first_name']) ?> <?= htmlspecialchars($student['last_name']) ?></p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="glass-card rounded-lg p-3">
                                <p class="text-xs text-subtle mb-1">Current Email</p>
                                <p class="font-medium text-sm" id="current-email"><?= htmlspecialchars($student['email']) ?></p>
                            </div>
                            <div class="glass-card rounded-lg p-3">
                                <p class="text-xs text-subtle mb-1">Updated Email</p>
                                <p class="font-medium text-sm" id="updated-email"><?= htmlspecialchars($student['email']) ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="glass-card rounded-2xl p-6 hover:shadow-2xl transition-all">
                    <h3 class="font-semibold mb-4">Update Status</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm">Changes Detected</span>
                            <span id="changes-badge" class="inline-flex items-center px-3 py-1 rounded-full text-sm badge-default">
                                No
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm">Ready to Update</span>
                            <span id="ready-badge" class="inline-flex items-center px-3 py-1 rounded-full text-sm badge-default">
                                No Changes
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Tips -->
                <div class="glass-card rounded-2xl p-6">
                    <div class="flex items-center gap-2 mb-2">
                        <i data-lucide="mail" class="h-4 w-4 text-blue-300"></i>
                        <span class="text-sm font-medium text-blue-200">Update Tips</span>
                    </div>
                    <p class="text-sm text-subtle">
                        Any changes will be saved when you press <strong>Update Student</strong>. Make sure all information is accurate before updating.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        function checkChanges() {
            const firstName = document.getElementById('first_name');
            const lastName  = document.getElementById('last_name');
            const email     = document.getElementById('email');

            const origFirst = firstName.dataset.original ?? '';
            const origLast  = lastName.dataset.original ?? '';
            const origEmail = email.dataset.original ?? '';

            const hasChanges =
                firstName.value.trim() !== origFirst ||
                lastName.value.trim() !== origLast ||
                email.value.trim() !== origEmail;

            // update preview fields
            document.getElementById('updated-name').textContent = (firstName.value || origFirst) + ' ' + (lastName.value || origLast);
            document.getElementById('updated-email').textContent = email.value || origEmail;

            const modifiedBadge = document.getElementById('modified-badge');
            const changesBadge  = document.getElementById('changes-badge');
            const readyBadge    = document.getElementById('ready-badge');
            const updateBtn     = document.getElementById('update-btn');

            if (hasChanges) {
                modifiedBadge.classList.remove('hidden');

                changesBadge.textContent = 'Yes';
                changesBadge.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm badge-blue';

                readyBadge.textContent = 'Ready';
                readyBadge.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm badge-green';

                updateBtn.disabled = false;
            } else {
                modifiedBadge.classList.add('hidden');

                changesBadge.textContent = 'No';
                changesBadge.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm badge-default';

                readyBadge.textContent = 'No Changes';
                readyBadge.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm badge-default';

                updateBtn.disabled = true;
            }
        }

        // initialize visual state on load
        document.addEventListener('DOMContentLoaded', function() {
            checkChanges();
        });
    </script>
</body>
</html>
