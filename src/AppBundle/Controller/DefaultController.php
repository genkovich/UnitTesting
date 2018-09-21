<?php

namespace AppBundle\Controller;

use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use DateTime;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $baseDir = realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR;
        $result = json_decode($request->getContent(), true);
        file_put_contents($baseDir .'var/logs/telegram.log', print_r($result, true));
        $responseBody = [
            'method' => 'sendMessage',
            'chat_id' => $result['message']['chat']['id'],
            'text' => 'olololo'
        ];

        $messaggio = 'asdsadsadasd';
        $chat = $result['message']['chat']['id'];


        $when = $result['message']['text'] == 'yesterday' ? 'yesterday' : 'today';
        $today = new DateTime($when);

        $client = new \GuzzleHttp\Client();
        $res = $client->request(
            'GET',
            'https://redmine.netpeak.net/time_entries.json?key=298c9dfcf8c5cc241d138449a32a7d8bc29ecb84&spent_on==' . $today->format('Y-m-d') . '&user_id=114',
            ['verify' => false,]
        );

        $time_entries = json_decode($res->getBody());

        $issues = [];
        foreach ($time_entries->time_entries as $entry) {
            $issues[] = $entry->issue->id;
        }

        $issuesString = implode(',', $issues);
        //15310,12653,12465,12464,27371,30714,33183,33517,32505,34586,31764,33516,33183
        $res = $client->request(
            'GET',
            'https://redmine.netpeak.net/issues.json?key=298c9dfcf8c5cc241d138449a32a7d8bc29ecb84&status_id=*&issue_id=' . $issuesString,
            ['verify' => false,]
        );

        $a = json_decode($res->getBody());
        $issuesFormatted = [];
        foreach ($a->issues as $issue) {
            $issuesFormatted[$issue->id] = $issue;
        }

        $b = [];
        $hours = 0;

       $responseBody = $this->render('telegram/time_entries.html.twig', [
            'entries' => $time_entries->time_entries,
            'issues' => $issuesFormatted,
        ]);
        foreach ($time_entries->time_entries as $entry) {
            $sub = !empty($issuesFormatted[$entry->issue->id]) ? $issuesFormatted[$entry->issue->id]->subject : 'not def';
            $hours += $entry->hours;
            $string = $entry->hours . ' | ' . $entry->comments . ' | ' . $sub;
            $b[] = $string;
        }


        $this->sendMessage($chat, $responseBody->getContent());
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);

    }

    /**
     * @param $chat
     * @param $responseBody
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function sendMessage($chat, $responseBody): void
    {
        $client = new \GuzzleHttp\Client();
        $token = $this->container->getParameter('tg_token');
        $url = "https://api.telegram.org/".$token."/sendMessage?chat_id=".$chat;
        $url = $url."&text=".urlencode($responseBody);
        $res = $client->request(
            'GET',
            $url
        );
    }


    /**
     * @Route("/redmine", name="redmine")
     */
    public function redmine(Request $request)
    {

        $file = new \SplFileObject('/home/genkovich/tessst.txt', 'a');
        var_dump($file); die;
        $client = new Client([
            ['verify' => false, 'debug' => true]
        ]);


        $url = 'https://redmine.netpeak.net/issues.json';
        $options = [
            'verify' => false,
            'query' => [
                'key' => '298c9dfcf8c5cc241d138449a32a7d8bc29ecb84',
                'status_id' => '*',
                'fixed_version_id' => '451'
            ]
        ];
        $response = $client->request('GET', $url, $options);
        $body = json_decode($response->getBody());
        $total = $body->total_count;

        for ($offset = 0; $offset < $total; $offset+= 25) {
            $options['query']['offset'] =  $offset;
            $requestUrl = $url . '?' . http_build_query($options['query']);
            $request = new \GuzzleHttp\Psr7\Request('GET', $requestUrl);
            $requests[] = $request;

        }
        $pool = Pool::batch($client, $requests, [
            'concurrency' => 5,
            'fulfilled' => function ($response, $index) {

            },
            'rejected' => function ($reason, $index) {
                // this is delivered each failed request
            },
        ]);
        var_dump($pool); die;
        $promise = $pool->promise();

        $promise->wait();
        var_dump($promise->getState()); die;
        return Response::create(1);
    }
}
