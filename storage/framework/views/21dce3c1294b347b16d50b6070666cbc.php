

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Health Diagnosis Report</title>
    <style>
        body {
            font-family: 'Poppins', 'Quicksand', sans-serif;
            background-color: #f4f7f6;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .report-wrapper {
            max-width: 800px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            border-top: 8px solid #28a745;
        }

        .report-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .report-header h1 {
            color: #28a745;
            font-size: 30px;
            margin-bottom: 5px;
        }

        .report-header p {
            font-size: 16px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 16px;
        }

        table th, table td {
            text-align: left;
            padding: 12px 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        table th {
            background-color: #e6f4ea;
            color: #28a745;
            font-weight: 600;
        }

        .symptoms {
            background-color: #e6f4ea;
            padding: 5px 10px;
            border-radius: 8px;
            display: inline-block;
        }

        .report-footer {
            margin-top: 40px;
            text-align: right;
            font-style: italic;
            color: #555;
        }

        @media print {
            body {
                background-color: #fff;
            }
            .report-wrapper {
                box-shadow: none;
                border-top: 6px solid #28a745;
                margin: 0;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="report-wrapper">
        <!-- Header -->
        <div class="report-header">
            <h1>Health Diagnosis Report</h1>
            <p>Comprehensive AI-based health analysis</p>
        </div>

        <!-- Report Table -->
        <table>
            <tr>
                <th>Name</th>
                <td><?php echo e($name); ?></td>
            </tr>
            <tr>
                <th>Age</th>
                <td><?php echo e($age); ?></td>
            </tr>
            <tr>
                <th>Gender</th>
                <td><?php echo e($gender); ?></td>
            </tr>
            <tr>
                <th>Diagnosis</th>
                <td><?php echo e($diagnosis); ?></td>
            </tr>
            <tr>
                <th>Symptoms</th>
                <td><span class="symptoms"><?php echo e(implode(', ', $symptoms)); ?></span></td>
            </tr>
        </table>

        <!-- Footer -->
        <div class="report-footer">
            <p>Date: <?php echo e($date); ?></p>
        </div>
    </div>
</body>
</html>

<?php /**PATH C:\wamp64\www\healthissuedetector\health-detector-api\resources\views/diagnosis_report.blade.php ENDPATH**/ ?>