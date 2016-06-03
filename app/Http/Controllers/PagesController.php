<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use GuzzleHttp\Client;


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
        
        return view('puntaje',['usuario' =>$usuario ,
            'evento' =>$eventScore ,
            'follower' =>$followerScore ,
            'star' =>$starScore,
            'score'=>$score ]);
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
