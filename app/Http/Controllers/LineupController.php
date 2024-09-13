<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Team;
use App\Models\Lineup;
use App\Models\Player;
use App\Traits\HasImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\LineupResource;

class LineupController extends Controller
{

    use HasImages;

    public function index(string $team_id)
    {
        try {
            $team = Team::find($team_id);
            $lineups = $team->lineups;
    
            Log::info(LineupResource::collection($lineups)->sortBy([['created_at', 'desc']]));

            if ($lineups) {
                return [
                    'data' => [
                        'team_logo' => $this->getImageFromPath($team->logo_path),
                        'team_name' => $team->name,
                        'team_manager' => $team->manager,
                        'team_coach' => $team->coach,
                        'lineups' => LineupResource::collection($lineups)
                    ]
                ];
            }
            
            return [
                'data' => [
                    'team_logo' => $this->getImageFromPath($team->logo_path),
                    'team_name' => $team->name,
                    'team_manager' => $team->manager,
                    'team_coach' => $team->coach,
                    'lineups' => []
                ]
            ];
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    public function store(Request $request, string $team_id) 
    {
        try {
            
            $newLineup = Lineup::create([
                'name' => $request->name,
                'opposing_team' => $request->opposing_team,
                'team_id' => $team_id,
            ]);

            foreach ($request->players as $player) {

                $savedPlayer = Player::find($player['id']);

                $newLineup->players()->attach($savedPlayer->id, [
                        'position_id' => $player['positions'][0]['id'],
                        'is_flex' => $player['is_flex']
                    ]
                );
            }

            $newLineup->save();

            return response()->json('Insertado con éxito', 201);

        } catch (\Throwable $th) {
            
            Log::error($th);

            return response()->json('Ocurrió un problema', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $lineup_id)
    {
        return new LineupResource(Lineup::find($lineup_id));
    }
}
