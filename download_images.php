<?php
// Create the blog images directory if it doesn't exist
$image_dir = 'assets/images/blog';
if (!file_exists($image_dir)) {
    mkdir($image_dir, 0777, true);
}

// Array of image URLs and their corresponding filenames
$images = [
    'ai-future.jpg' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995',
    'healthy-habits.jpg' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b',
    'travel-destinations.jpg' => 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800',
    'cooking-tips.jpg' => 'https://images.unsplash.com/photo-1556911220-bff31c812dba',
    'minimalism.jpg' => 'https://images.unsplash.com/photo-1494438639946-1ebd1d20bf85',
    'digital-marketing.jpg' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f'
];

// Download each image
foreach ($images as $filename => $url) {
    $image_path = $image_dir . '/' . $filename;
    
    // Download the image
    $image_data = file_get_contents($url);
    if ($image_data !== false) {
        file_put_contents($image_path, $image_data);
        echo "Downloaded: $filename\n";
    } else {
        echo "Failed to download: $filename\n";
    }
}

echo "Image download complete!\n";
?> 