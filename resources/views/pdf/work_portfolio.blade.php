<!doctype html>
+ <html>
+ <head>
+     <meta charset="utf-8">
+     <title>Work Portfolio</title>
+     <style> body { font-family: sans-serif; } h1 { text-align: center; } .job { margin-bottom: 20px; } .rating { font-weight: bold; } </style>
+ </head>
+ <body>
+     <h1>Work Portfolio for {{ $user->name }}</h1>
+     <p>Generated on {{ now()->format('F j, Y') }}</p>
+     @foreach($jobs as $job)
+         <div class="job">
+             <h2>{{ $job->title }}</h2>
+             <p><strong>Completed On:</strong> {{ \Carbon\Carbon::parse($job->completed_at)->format('F j, Y') }}</p>
+             <p><strong>Employer:</strong> {{ $job->employer_name }}</p>
+             <p class="rating">Rating: {{ $job->rating }} / 5</p>
+             <p><em>"{{ $job->comment }}"</em></p>
+         </div>
+     @endforeach
+ </body>
+ </html>

