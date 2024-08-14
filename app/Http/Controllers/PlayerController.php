<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\PlayerResource;
use App\Http\Validations\PlayerValidationRules;

class PlayerController extends Controller
{
    use PlayerValidationRules;

    public function store(Request $request) 
    {
        $request->validate($this->playerStoreValidationRules());

        try {
            
            $newPlayer = Player::create([
                'name' => $request->name,
                'number' => $request->number,
                'team_id' => $request->team_id,
            ]);

            foreach ($request->positions as $position) {
                $newPlayer->positions()->attach($position);
            }

            $newPlayer->save();

            return response()->json('Insertado con éxito', 201);

        } catch (\Throwable $th) {
            
            Log::error($th);

            return response()->json('Ocurrió un problema', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new PlayerResource(Player::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate($this->playerUpdateValidationRules());

        $request = $request->all();

        try {
            
            $player = Player::find($id);

            foreach ($request as $column => $update) {
                
                if ($column == "positions") {
                
                    $player->positions()->detach();

                    foreach ($request[$column] as $position_id) {

                        $player->positions()->attach($position_id);    
                    }

                } else {
                    $player[$column] = $update; 
                }
            }

            $player->save();

            return response()->json('Actualizado con éxito', 201);
            
        } catch (\Throwable $th) {
            
            Log::error($th);

            return response()->json('Ocurrió un problema', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $player = Player::find($id);

        $player->delete();
    }
}
