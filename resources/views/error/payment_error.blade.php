<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foods</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body class="flex h-screen font-roboto">
    <div class="min-h-screen w-full bg-gray-100 flex items-center justify-center">
        <x-error-component 
            error-title="Payment Error"
            error-text="An error occured during the payment process, please try again"
            error-text-button="Back to Home"
            redirect-route="customer.home" 
        />
    </div>
</body>
</html>