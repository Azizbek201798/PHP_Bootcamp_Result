<!-- Pagination -->
<nav aria-label="Page navigation example">
    <ul class="pagination">
        <li class="page-item <?php if ($page <= 1) { echo 'disabled'; } ?>">
            <br><a class="page-link" href="<?php if ($page > 1) { echo '?page=' . ($page - 1); } else { echo '#'; } ?>">Previous</a>
        </li>
        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
            <li class="page-item <?php if ($page == $i) { echo 'active'; } ?>">
                <br><a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
            </li>
        <?php endfor; ?>
        <li class="page-item <?php if ($page >= $total_pages) { echo 'disabled'; } ?>">
            <br><a class="page-link" href="<?php if ($page < $total_pages) { echo '?page=' . ($page + 1); } else { echo '#'; } ?>">Next</a>
        </li>
    </ul>
</nav>