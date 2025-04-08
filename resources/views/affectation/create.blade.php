@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-2xl px-4 py-8 bg-white rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Affecter un courrier à un agent</h2>

    @if(session('error'))
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('affectation.store') }}" class="space-y-4">
        @csrf

        <input type="hidden" name="courrier_id" value="{{ $courrier->id }}">

        <div>
            <label class="block text-sm font-medium text-gray-700">Référence du courrier :</label>
            <div class="mt-1 text-gray-900 font-semibold">{{ $courrier->reference_expediteur }}</div>
        </div>

        <div>
            <label for="user_id" class="block text-sm font-medium text-gray-700">Choisir l’agent destinataire</label>
            <select id="user_id" name="user_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-green-300">
                @foreach($agents as $agent)
                    <option value="{{ $agent->id }}">{{ $agent->name }} ({{ $agent->email }})</option>
                @endforeach
            </select>
            @error('user_id')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="observation" class="block text-sm font-medium text-gray-700">Observation (facultatif)</label>
            <textarea id="observation" name="observation" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-green-300">{{ old('observation') }}</textarea>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Affecter
            </button>
        </div>
    </form>
</div>
@endsection
