<?php
include('../config/config.php');

// Fetch messages from the database
$query = "SELECT message_id, name, email, subject, message, sent_at FROM messages ORDER BY message_id DESC";
$result = mysqli_query($conn, $query);

// Check if query was successful and fetch data into an array
$messages = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $messages[] = $row;
    }
}
?>

<section class="py-4">
    <div class="container">
        <h2 class="text-center" style="font-size: 1.75rem; margin-bottom: 1rem; color: #333;">Messages</h2>
        <hr>
        <div class="message-list">
            <?php foreach ($messages as $message) : ?>
                <div class="card mb-3" style="border: 1px solid #ddd; border-radius: 8px; transition: transform 0.2s;">
                    <div class="card-body" style="padding: 15px;">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="mb-1" style="margin: 0;"><strong>Subject:</strong> <?= htmlspecialchars($message['subject']); ?></h5>
                                <p class="mb-1" style="margin: 0;"><strong>Message:</strong> <?= substr(htmlspecialchars($message['message']), 0, 50) . '...'; ?></p>
                                <p class="mb-1 text-muted" style="font-size: 0.9rem; font-style: italic; margin: 0;">
                                    <strong>From:</strong> <?= htmlspecialchars($message['name']); ?> (<?= htmlspecialchars($message['email']); ?>)
                                </p>
                            </div>
                            <div class="text-muted" style="font-size: 0.9rem; font-style: italic;">
                                <small><strong>Date:</strong> <?= htmlspecialchars($message['sent_at']); ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
