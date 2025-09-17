<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Report Card</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 20px;
            padding: 20px;
        }
        
        .report-card {
            background-color: #f5f5dc !important;
            border: 2px solid #8B4513;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .header {
            text-align: center;
            background-color: #f5f5dc !important;
            color: #8B4513 !important;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 20px;
        }
        
        .marks-table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #8B4513;
            margin-bottom: 30px;
        }
        
        .marks-table th, .marks-table td {
            border: 1px solid #8B4513;
            padding: 8px;
            text-align: center;
            color: #8B4513;
        }
        
        .marks-table th {
            background-color: #f0e68c;
            font-weight: bold;
        }
        
        .marks-table td {
            background-color: #f5f5dc;
        }
        
        .subject-name {
            text-align: left;
            padding-left: 10px;
        }
        
        .total-marks {
            color: #8B4513;
            font-weight: bold;
        }
        
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 80px;
            color: #8B4513;
        }
        
        .signature-box {
            text-align: center;
            border-bottom: 1px solid #8B4513;
            padding-bottom: 5px;
            min-width: 150px;
        }
        
        .signature-label {
            margin-top: 10px;
            font-size: 14px;
        }
        
        .editable {
            background-color: white;
            border: 1px solid #ccc;
            padding: 2px;
            min-height: 20px;
        }
        
        .editable:focus {
            outline: 2px solid #8B4513;
            background-color: #fff8dc;
        }
        
        .input-section {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #fff8dc;
            border: 1px solid #8B4513;
            border-radius: 5px;
        }
        
        .input-section label {
            display: inline-block;
            margin-right: 10px;
            color: #8B4513;
            font-weight: bold;
        }
        
        .input-section input {
            margin-right: 20px;
            padding: 5px;
            border: 1px solid #8B4513;
            border-radius: 3px;
        }
    </style>
</head>

@extends('admin.layouts.app')

@section('content')
<body>
    <div class="report-card">
        <div class="header">
            R.M.S.S Dharharwa, Muzaffarpur
        </div>
        
        <div class="input-section">
            <div class="row">
            <div class="col">
            <label>Student Name:</label>
            <input type="text" id="studentName" value="{{ $student->first_name }} {{ $student->last_name }}" readonly>
            </div>
            <div class="col">
            <label>Class:</label>
            <!-- <input type="text" id="studentClass" value="{{ $student->class->name ?? '' }}" readonly> -->
            <input type="text" id="studentClass" value="{{ $student->class->name ?? ''}} - {{ $student->section->name }} " readonly>
            </div>
            <div class="col">
            <label>Roll No:</label>
            <input type="text" id="rollNo" value="{{ $student->roll_no }}" readonly>
            </div>
            </div>
        </div>
        
        <table class="marks-table">
        <thead>
        <tr>
            <th>Sl. No.</th>
            <th>Subject</th>
            <th>Full Marks</th>
            <th>1st Terminal</th>
            <th>2nd Terminal</th>
            <th>Annual Exam</th>
            <th>Total Full Marks</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>
    @php
        $sumTerm1 = 0;
        $sumTerm2 = 0;
        $sumAnnual = 0;
        $sumTotal = 0;
        $sumMaxMarks = 0;
        $sumTotalFullMarks = 0;
        $term1Percent = 0;
        $term2Percent = 0;
        $annualPercent = 0;
    @endphp
    @foreach ($marks->groupBy(function($mark) {
        return $mark->subject->name ?? 'Unknown Subject';
    }) as $subject => $records)
        @php
            $term1Mark = $records->first(fn($mark) => $mark->exam && $mark->exam->term === 'Term 1');
            $term2Mark = $records->first(fn($mark) => $mark->exam && $mark->exam->term === 'Term 2');
            $annualMark = $records->first(fn($mark) => $mark->exam && $mark->exam->term === 'Annual Term');

            $term1 = $term1Mark?->marks_obtained ?? 0;
            $term2 = $term2Mark?->marks_obtained ?? 0;
            $annual = $annualMark?->marks_obtained ?? 0;

            $maxMarksTerm1 = $term1Mark?->exam?->max_marks ?? 0;
            $maxMarksTerm2 = $term2Mark?->exam?->max_marks ?? 0;
            $maxMarksAnnual = $annualMark?->exam?->max_marks ?? 0;

            // Show the max_marks for the subject (assuming all terms have the same max_marks, fallback to the first non-zero)
            $maxMarks = $maxMarksTerm1 ?: ($maxMarksTerm2 ?: $maxMarksAnnual);

            $total = $term1 + $term2 + $annual;
            $percentage = ($maxMarks > 0) ? ($total / ($maxMarks * 3)) * 100 : 0;

            $sumTerm1 += $term1;
            $sumTerm2 += $term2;
            $sumAnnual += $annual;
            $sumTotal += $total;
            $sumMaxMarks += $maxMarks;
            $sumTotalFullMarks += ($maxMarks * 3);
        @endphp
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $subject }}</td>
            <td>{{ $maxMarks }}</td>
            <td>{{ $term1 }}</td>
            <td>{{ $term2 }}</td>
            <td>{{ $annual }}</td>
            <td><b>{{ $maxMarks * 3 }}</b></td>
            <td></td>
        </tr>
    @endforeach
    <tr style="font-weight:bold; background-color:#f0e68c;">
        @php
            $term1Percent = $sumMaxMarks > 0 ? round(($sumTerm1 / $sumMaxMarks) * 100, 1) : 0;
            $term2Percent = $sumMaxMarks > 0 ? round(($sumTerm2 / $sumMaxMarks) * 100, 1) : 0;
            $annualPercent = $sumMaxMarks > 0 ? round(($sumAnnual / $sumMaxMarks) * 100, 1) : 0;
        @endphp
        <td colspan="2">Total</td>
        <td>{{ $sumMaxMarks }}</td>
        <td>{{ $sumTerm1 }}</td>
        <td>{{ $sumTerm2 }}</td>
        <td>{{ $sumAnnual }}</td>
        <td>{{ $sumTotalFullMarks }}</td>
        <td></td>
    </tr>
    <tr style="font-weight:bold; background-color:#f0e68c;">
        <td colspan="3">Percentage %</td>
        <td>{{ $term1Percent }}%</td>
        <td>{{ $term2Percent }}%</td>
        <td>{{ $annualPercent }}%</td>
        <td></td>
    </tr>
</tbody>
</table>
        
        <div class="signature-section">
            <div>
                <div class="signature-box"></div>
                <div class="signature-label">Character</div>
            </div>
            <div>
                <div class="signature-box"></div>
                <div class="signature-label">Sign. of Guardians</div>
            </div>
            <div>
                <div class="signature-box"></div>
                <div class="signature-label">Sign. of Class teacher</div>
            </div>
            <div>
                <div class="signature-box"></div>
                <div class="signature-label">Sign. and Seal of Principal</div>
            </div>
        </div>
    </div>
    
    <script>
        // Auto-calculate percentage when marks are entered
        document.querySelectorAll('.editable').forEach(cell => {
            cell.addEventListener('input', function() {
                const row = this.closest('tr');
                const terminalCells = row.querySelectorAll('.editable');
                const percentageCell = terminalCells[4]; // 5th editable cell is percentage
                
                if (terminalCells.length >= 4) {
                    const term1 = parseFloat(terminalCells[0].textContent) || 0;
                    const term2 = parseFloat(terminalCells[1].textContent) || 0;
                    const annual = parseFloat(terminalCells[2].textContent) || 0;
                    const total = term1 + term2 + annual;
                    const fullMarks = parseFloat(row.cells[2].textContent) || 0;
                    const totalFullMarks = fullMarks * 3;
                    
                    if (totalFullMarks > 0) {
                        const percentage = ((total / totalFullMarks) * 100).toFixed(1);
                        percentageCell.textContent = percentage + '%';
                    }

                }
            });
        });
    </script>
</body>
</html>

@endsection 