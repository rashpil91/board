<?php if ($photo): ?>

    <div class="row">
        <?php foreach ($photo as $k => $item): ?>
            <div class="photo_item col-sm-6 col-md-4">
                <div class="thumbnail">
                    <img src="/uploads/board/thumbs/<?= $item['filename'] ?>" alt="...">
                    <div class="caption">
                        <p>
                            <a href="#" class="photo_delete btn btn-danger" data-id="<?= $item['id']?>" role="button">
                                <i class="glyphicon glyphicon-remove"></i>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<?php endif; ?>
