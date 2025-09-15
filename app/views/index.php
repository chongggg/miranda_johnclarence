<!-- Table of Students -->
<table class="w-full border-collapse border border-gray-300">
    <thead>
        <tr>
            <th class="border p-2">ID</th>
            <th class="border p-2">First Name</th>
            <th class="border p-2">Last Name</th>
            <th class="border p-2">Email</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($students)): ?>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td class="border p-2"><?php echo $student['id']; ?></td>
                    <td class="border p-2"><?php echo $student['first_name']; ?></td>
                  <td class="border p-2"><?php echo $student['last_name']; ?></td>
                    <td class="border p-2"><?php echo $student['email']; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="3" class="text-center p-4">No records found</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Pagination Controls -->
<?php if (isset($pagination_data)): ?>
    <div class="mt-8">
        <?php if (isset($pagination_links) && !empty($pagination_links)): ?>
            <div class="flex justify-center mb-4">
                <?php echo $pagination_links; ?>
            </div>
        <?php endif; ?>

        <div class="flex justify-between items-center text-sm text-gray-600">
            <div>
                <?php echo $pagination_data['info']; ?>
            </div>
            <div class="flex items-center space-x-2">
                <span>Items per page:</span>
                <select id="itemsPerPage" class="px-3 py-1 bg-gray-200 border border-gray-300 rounded-lg text-gray-700">
                    <option value="10" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == 10) ? 'selected' : ''; ?>>10</option>
                    <option value="25" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == 25) ? 'selected' : ''; ?>>25</option>
                    <option value="50" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == 50) ? 'selected' : ''; ?>>50</option>
                    <option value="100" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == 100) ? 'selected' : ''; ?>>100</option>
                </select>
            </div>
        </div>
    </div>
<?php endif; ?>
