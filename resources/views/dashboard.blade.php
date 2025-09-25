<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NBA Draft Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f4f4f4; }
        input { padding: 5px; margin: 5px; }
        button { padding: 5px 10px; margin: 5px; cursor: pointer; }
        .form-container { margin-top: 20px; border: 1px solid #ccc; padding: 15px; border-radius: 8px; }
        .success { color: green; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h1>NBA Draft Manager</h1>

    {{-- Success Message --}}
    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    {{-- Initialize $drafts to avoid errors --}}
    @php
        $drafts = $drafts ?? collect();
        $isEditing = isset($nbaDraft);
    @endphp

    {{-- Add / Edit Form --}}
    <div class="form-container">
        <h2>{{ $isEditing ? 'Edit Player' : 'Add New Player' }}</h2>

        <form action="{{ $isEditing ? route('nba.update', $nbaDraft->id) : route('nba.store') }}" method="POST">
            @csrf
            @if($isEditing)
                @method('PUT')
            @endif

            <input type="text" name="name" placeholder="Name" value="{{ old('name', $isEditing ? $nbaDraft->name : '') }}" required>
            <input type="text" name="team" placeholder="Team" value="{{ old('team', $isEditing ? $nbaDraft->team : '') }}" required>
            <input type="number" name="draft_year" placeholder="Draft Year" value="{{ old('draft_year', $isEditing ? $nbaDraft->draft_year : '') }}" required>
            <input type="number" name="pick_number" placeholder="Pick Number" value="{{ old('pick_number', $isEditing ? $nbaDraft->pick_number : '') }}" required>
            
            <button type="submit">{{ $isEditing ? 'Update Player' : 'Add Player' }}</button>
            
            @if($isEditing)
                <a href="{{ route('nba.index') }}"><button type="button">Cancel</button></a>
            @endif
        </form>
    </div>

    {{-- Players Table --}}
    <h2>All Draft Picks</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Team</th>
                <th>Draft Year</th>
                <th>Pick Number</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($drafts as $draft)
            <tr>
                <td>{{ $draft->name }}</td>
                <td>{{ $draft->team }}</td>
                <td>{{ $draft->draft_year }}</td>
                <td>{{ $draft->pick_number }}</td>
                <td>
                    <a href="{{ route('nba.edit', $draft->id) }}"><button>Edit</button></a>
                    <form action="{{ route('nba.destroy', $draft->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this player?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">No players found. Add some!</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
