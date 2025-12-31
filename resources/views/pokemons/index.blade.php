<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pokemon List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1d1f21; /* Dark background */
            color: #f8f9fa; /* Light text */
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #ffcc00; /* Bright color for title */
        }

        .form-select {
            background-color: #343a40; /* Form background */
            border: 1px solid #ffcc00; /* Border color */
            color: #f8f9fa; /* Text color */
        }

        .form-select:focus {
            border-color: #ffc107; /* Focus border color */
            box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25); /* Shadow effect */
        }

        .card {
            background-color: #2c2f33; /* Card background */
            border: none; /* Remove default border */
            transition: transform 0.3s; /* Hover effect */
            color: #ffcc00; /* Card text color */
        }

        .card:hover {
            transform: translateY(-5px); /* Lift effect on hover */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3); /* Shadow on hover */
        }

        .card-img-top {
            height: 150px; /* Adjusted height for images */
            object-fit: contain; /* Keep aspect ratio */
        }

        ul {
            padding-left: 0; /* Remove default padding */
            list-style-type: none; /* Remove bullets */
        }

        li {
            background-color: #444; /* Background for list items */
            border-radius: 5px; /* Rounded corners */
            margin-bottom: 5px; /* Space between items */
            padding: 5px; /* Padding for list items */
        }
    </style>
</head>
<body>

<div class="container mt-4">

    <h2>Daftar Pokémon</h2>

    <!-- FILTER -->
    <form method="GET" class="mb-4 text-center">
        <select name="weight_filter" class="form-select w-25 mx-auto" onchange="this.form.submit()">
            <option value="">-- Semua Berat --</option>
            <option value="light" {{ request('weight_filter') == 'light' ? 'selected' : '' }}>
                Light (0 - 200)
            </option>
            <option value="medium" {{ request('weight_filter') == 'medium' ? 'selected' : '' }}>
                Medium (201 - 300)
            </option>
            <option value="heavy" {{ request('weight_filter') == 'heavy' ? 'selected' : '' }}>
                Heavy (> 300)
            </option>
        </select>
    </form>

    <!-- LIST POKEMON -->
    <div class="row">
        @foreach ($pokemons as $pokemon)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">

                    <img src="{{ asset($pokemon->image_path) }}"
                         class="card-img-top">

                    <div class="card-body">
                        <h5 class="card-title">{{ $pokemon->name }}</h5>


                        <p class="mb-1"><strong>Base Exp:</strong> {{ $pokemon->base_experience }}</p>
                        <p class="mb-2"><strong>Weight:</strong> {{ $pokemon->weight }}</p>
                        <p class="mb-2"><strong>Stat:</strong> {{ $pokemon->stat }}</p>

                        <strong>Abilities:</strong>
                        <ul>
                            @foreach ($pokemon->abilities as $ability)
                                <li>{{ $ability->name }}</li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        @endforeach
    </div>

</div>

</body>
</html>
