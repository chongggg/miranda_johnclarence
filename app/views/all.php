<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Student Management Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.75rem;
            margin-top: 2rem;
            font-family: "Inter", sans-serif;
        }

        .pagination .page-item {
            list-style: none;
        }

        .pagination .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 42px;
            height: 42px;
            padding: 0 1rem;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(18px) saturate(180%);
            -webkit-backdrop-filter: blur(18px) saturate(180%);
            color: #f9fafb;
            font-size: 0.95rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.25s ease;
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        .pagination .page-link:hover {
            background: rgba(59, 130, 246, 0.6);
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 6px 18px rgba(59, 130, 246, 0.35);
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
            transform: scale(1.08);
        }

        .pagination .page-link:active {
            transform: scale(0.95);
        }

        /* Custom styles for per page selector */
        .per-page-selector {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: white;
            padding: 8px 12px;
        }

        .per-page-selector option {
            background: #1e293b;
            color: white;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-900 via-blue-950 to-black text-white">
    <div class="min-h-screen bg-gradient-to-br from-blue-900 via-blue-950 to-black text-white">
        <!-- Navigation -->
        <nav class="fixed top-0 w-full bg-white/10 backdrop-blur-md shadow-lg z-50">
            <div class="max-w-6xl mx-auto px-6 py-3 flex justify-between items-center">
                <span class="text-xl font-bold tracking-wide">🎓 Student Management</span>
                <a href="index.php/students/create" 
                   class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 
                          px-5 py-2 rounded-xl shadow-lg hover:scale-105 transition">
                    + Add Student
                </a>
            </div>
        </nav>

        <!-- Header Section -->
        <section class="pt-28 pb-12 text-center">
            <h1 class="text-5xl md:text-6xl font-extrabold tracking-wide bg-gradient-to-r from-blue-400 to-indigo-500 bg-clip-text text-transparent">
                🎓 Student Management
            </h1>
        </section>

        <div class="max-w-6xl mx-auto p-6 space-y-6">
            <!-- Success/Error Messages -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="bg-green-500/20 border border-green-500/50 text-green-200 px-4 py-3 rounded-lg">
                    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="bg-red-500/20 border border-red-500/50 text-red-200 px-4 py-3 rounded-lg">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <!-- Search and Controls -->
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                <form method="GET" action="/students" class="flex-1 max-w-md">
                    <?php if (isset($per_page) && $per_page != 10): ?>
                        <input type="hidden" name="per_page" value="<?= $per_page ?>">
                    <?php endif; ?>
                    <div class="relative">
                        <input type="text" 
                               name="search"
                               id="searchInput"
                               value="<?= htmlspecialchars($search ?? '') ?>"
                               placeholder="🔍 Search students..."
                               class="w-full px-4 py-2 rounded-lg bg-white/10 backdrop-blur-md border border-white/20 
                                      focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-md">
                        <?php if (!empty($search)): ?>
                            <a href="/students" class="absolute right-2 top-2 text-gray-400 hover:text-white">✕</a>
                        <?php endif; ?>
                    </div>
                </form>

                <!-- Per Page Selector -->
                <form method="GET" action="/students" class="flex items-center gap-2">
                    <?php if (!empty($search)): ?>
                        <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
                    <?php endif; ?>
                    <label for="per_page" class="text-sm text-gray-300">Show:</label>
                    <select name="per_page" 
                            id="per_page" 
                            class="per-page-selector"
                            onchange="this.form.submit()">
                        <option value="10" <?= ($per_page ?? 10) == 10 ? 'selected' : '' ?>>10</option>
                        <option value="25" <?= ($per_page ?? 10) == 25 ? 'selected' : '' ?>>25</option>
                        <option value="50" <?= ($per_page ?? 10) == 50 ? 'selected' : '' ?>>50</option>
                        <option value="100" <?= ($per_page ?? 10) == 100 ? 'selected' : '' ?>>100</option>
                    </select>
                    <span class="text-sm text-gray-300">per page</span>
                </form>
            </div>

            <!-- Pagination Info -->
            <?php if (isset($pagination_info) && !empty($pagination_info)): ?>
                <div class="text-center">
                    <p class="text-gray-300"><?= $pagination_info ?></p>
                </div>
            <?php endif; ?>

            <!-- Students Table -->
            <div class="overflow-x-auto rounded-2xl shadow-xl bg-white/10 backdrop-blur-md">
                <table id="studentsTable" class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white uppercase tracking-wider">
                            <th class="py-3 px-6 text-left">ID</th>
                            <th class="py-3 px-6 text-left">Last Name</th>
                            <th class="py-3 px-6 text-left">First Name</th>
                            <th class="py-3 px-6 text-left">Email</th>
                            <th class="py-3 px-6 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        <?php if (!empty($students)): ?>
                            <?php foreach($students as $s): ?>
                                <tr class="hover:bg-blue-500/20 hover:shadow-lg hover:shadow-blue-500/30 transition">
                                    <td class="py-3 px-6 font-semibold">#<?= htmlspecialchars($s['id']) ?></td>
                                    <td class="py-3 px-6"><?= htmlspecialchars($s['last_name']) ?></td>
                                    <td class="py-3 px-6"><?= htmlspecialchars($s['first_name']) ?></td>
                                    <td class="py-3 px-6 text-gray-300"><?= htmlspecialchars($s['email']) ?></td>
                                    <td class="py-3 px-6 text-center space-x-2">
                                        <a href="index.php/students/edit/<?= $s['id'] ?>" 
                                           class="bg-yellow-400 hover:bg-yellow-500 text-black px-3 py-1 rounded-md shadow hover:shadow-yellow-400/50 transition">
                                            Edit
                                        </a>
                                        <a href="index.php/students/delete/<?= $s['id'] ?>" 
                                           onclick="return confirm('Are you sure you want to delete this student?')" 
                                           class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded-md shadow-md shadow-red-500/50 transition">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-400">
                                    <div class="text-2xl">📚</div>
                                    <p class="mt-2">
                                        <?php if (!empty($search)): ?>
                                            No students found matching "<?= htmlspecialchars($search) ?>".
                                        <?php else: ?>
                                            No students found.
                                        <?php endif; ?>
                                    </p>
                                    <?php if (!empty($search)): ?>
                                        <a href="/students" class="text-blue-400 hover:text-blue-300 underline mt-2 inline-block">
                                            Show all students
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination Controls -->
            <?php if (isset($pagination_html) && !empty($pagination_html)): ?>
                <div class="pagination-wrapper">
                    <?= $pagination_html ?>
                </div>
            <?php endif; ?>

            <!-- Additional pagination info for debugging -->
            <?php if (isset($current_page) && isset($total_pages)): ?>
                <div class="text-center text-sm text-gray-400 mt-4">
                    Page <?= $current_page ?> of <?= $total_pages ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Auto-submit search form on input with debounce
        let searchTimeout;
        document.getElementById("searchInput").addEventListener("input", function() {
            clearTimeout(searchTimeout);
            const form = this.form;
            searchTimeout = setTimeout(() => {
                form.submit();
            }, 500); // 500ms delay
        });

        // Handle browser back/forward buttons
        window.addEventListener('popstate', function(e) {
            window.location.reload();
        });

        // Show loading state for better UX
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = form.querySelector('input[type="submit"], button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Loading...';
                }
            });
        });
    </script>
</body>
</html>