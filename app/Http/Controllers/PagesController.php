<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use GuzzleHttp\Client;
use App\User;

class PagesController extends Controller
{




    public function home()
    {
    

        return view('welcome');
    }

        public function score_post(Request $request)
    {
        $usuario = $request->input('usuario');
        $eventScore = $this->eventScore($usuario);
        $followerScore = $this->followerScore($usuario);
        $starScore = $this->starScore($usuario);

        /*
        $result = array('usuario' =>$usuario ,
            'evento' =>$eventScore ,
            'follower' =>$followerScore ,
            'star' =>$starScore  );
       */
        $score = 0.4 * $eventScore + 0.4 * $starScore + 0.2 * $followerScore;
        
        $check = User::where('usuario', $usuario)->first();
        
        if (is_null($check)) {
            $user= new User;
            $user->usuario = $usuario;
            $user->enlace = "https://api.github.com/users/{$usuario}";
            $user->events = $eventScore;
            $user->followers = $followerScore;
            $user->stars = $starScore;
            $user->score = $score;

            $user->save();
        }
        

        return view('puntaje',['usuario' =>$usuario ,
            'evento' =>$eventScore ,
            'follower' =>$followerScore ,
            'star' =>$starScore,
            'score'=>$score ]);
    }


    public function batalla_post(Request $request)
    {
        $usuarioA = $request->input('usuarioA');
        $usuarioB = $request->input('usuarioB');
        $eventScoreA = $this->eventScore($usuarioA);
        $followerScoreA = $this->followerScore($usuarioA);
        $starScoreA = $this->starScore($usuarioA);

        $eventScoreB = $this->eventScore($usuarioB);
        $followerScoreB = $this->followerScore($usuarioB);
        $starScoreB = $this->starScore($usuarioB);

        /*
        $result = array('usuario' =>$usuario ,
            'evento' =>$eventScore ,
            'follower' =>$followerScore ,
            'star' =>$starScore  );
       */
        $scoreA = 0.4 * $eventScoreA + 0.4 * $starScoreA + 0.2 * $followerScoreA;
        $scoreB = 0.4 * $eventScoreB + 0.4 * $starScoreB + 0.2 * $followerScoreB;

        if ($scoreA > $scoreB)
            $ganador=$usuarioA;
        else
            $ganador = $usuarioB;


         $check = User::where('usuario', $usuarioA)->first();
        
        if (is_null($check)) {
            $user= new User;
            $user->usuario = $usuarioA;
            $user->enlace = "https://api.github.com/users/{$usuarioA}";
            $user->events = $eventScoreA;
            $user->followers = $followerScoreA;
            $user->stars = $starScoreA;
            $user->score = $scoreA;

            $user->save();
        }

         $check2 = User::where('usuario', $usuarioB)->first();
        
        if (is_null($check2)) {
            $user= new User;
            $user->usuario = $usuarioB;
            $user->enlace = "https://api.github.com/users/{$usuarioB}";
            $user->events = $eventScoreB;
            $user->followers = $followerScoreB;
            $user->stars = $starScoreB;
            $user->score = $scoreB;

            $user->save();
        }
        
        return view('batalla',['usuarioA' =>$usuarioA ,
            'eventoA' =>$eventScoreA ,
            'followerA' =>$followerScoreA ,
            'starA' =>$starScoreA,
            'scoreA'=>$scoreA,
            'usuarioB' =>$usuarioB ,
            'eventoB' =>$eventScoreB ,
            'followerB' =>$followerScoreB ,
            'starB' =>$starScoreB,
            'scoreB'=>$scoreB,
            'ganador'=>$ganador]);
    }

    public function batalla(){
        return view('batalla');
    }

    public function score(){
        return view('puntaje');
    }

    private  function eventScore($usuario){

        $client = new Client(['base_uri' => 'https://api.github.com/users/']);
        
        $res = $client->request('GET', "{$usuario}/events");

        $result= json_decode($res->getBody(), true);

        $score = 0;
        
        foreach ($result as $evento) {
            $event = $evento['type'];

            if ($event == 'PushEvent') {
                $score += 5;
                continue;
            }
            if ($event == 'CreateEvent') {
                $score += 4;
                continue;
            }
            if ($event == 'IssuesEvent') {
                $score += 3;
                continue;
            }
            if ($event == 'CommitCommentEvent') {
                $score += 2;
                continue;
            }
            else{
                $score += 1;
                continue;
            }


        }
        return $score;
    }

      private function followerScore($usuario)
    {
        $client = new Client(['base_uri' => 'https://api.github.com/users/']);
        
        $res = $client->request('GET', "{$usuario}"); //deberia funcionar 
 
        $result= json_decode($res->getBody(), true);

        $score = 0;      
        $score = $result['followers'];
        return $score;
    }


    private function starScore($usuario){
        $client = new Client(['base_uri' => 'https://api.github.com/users/']);
        
        $res = $client->request('GET', "{$usuario}/repos"); //deberia funcionar 
 
        $result= json_decode($res->getBody(), true);

        $score = 0;      
        foreach ($result as $repo ) {
            $score += intval($repo['stargazers_count']); 
        }
        
        return $score;
    }


    public function about()
    {
        


    	return view('pages.about');
    }
}
