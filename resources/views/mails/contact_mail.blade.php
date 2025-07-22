<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Message</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: #f4f4f4;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border-radius: 6px; border: 1px solid #ddd;">
        <h2 style="color: #333333;">New Message</h2>

        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <tr>
                <td style="border: 1px solid #888888; padding: 10px; font-weight: bold; background-color: #f0f0f0;">Name</td>
                <td style="border: 1px solid #888888; padding: 10px;">{{ $data['name'] }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #888888; padding: 10px; font-weight: bold; background-color: #f0f0f0;">Email</td>
                <td style="border: 1px solid #888888; padding: 10px;">{{ $data['email'] }}</td>
            </tr>
             <tr>
                <td style="border: 1px solid #888888; padding: 10px; font-weight: bold; background-color: #f0f0f0;">Subject</td>
                <td style="border: 1px solid #888888; padding: 10px;">{{ $data['subject'] }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #888888; padding: 10px; font-weight: bold; background-color: #f0f0f0;">Message</td>
                <td style="border: 1px solid #888888; padding: 10px;">{{ $data['message'] }}</td>
            </tr>

        </table>

        <p style="margin-top: 20px; color: red;">Please check the order details in the admin panel.</p>
    </div>
</body>
</html>
