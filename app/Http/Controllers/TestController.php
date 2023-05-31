<?php

namespace App\Http\Controllers;

use phpseclib3\Net\SSH2;

class TestController extends Controller
{
    public function view(){
        return view('dashboard');
    }

    protected function sshLogin($serverName = '20'){

        $serverCredantial = config("serversData.serverCredantial");
        if(empty($serverCredantial) || empty($serverCredantial[$serverName])){
            return [
                'status' => 'failed',
                'error_message' => 'server credantial not found'                
            ];
        }

        $host = $serverCredantial[$serverName]['host'] ?? 0;
        $port = $serverCredantial[$serverName]['port'] ?? 0;
        $user = $serverCredantial[$serverName]['user'] ?? 0;
        $password = $serverCredantial[$serverName]['password'] ?? 0;

        $ssh = new SSH2($host, $port); 

        if (!$ssh->login($user, $password)) {
            return [
                'status' => 'failed',
                'error_message' => 'Login Failed'                
            ];
        }
        return [
            'status' => 'success',
            'response' => $ssh         
        ];
    }

    public function runCommand(){
        $serverName = request()->input('serverName');
        $ssh = $this->sshLogin($serverName);
        if($ssh['status'] != 'success'){
            return response()->json($ssh);
        }
        $ssh = $ssh['response'];
        $commandId = request()->input('commandId');
        $projectId = request()->input('projectId');

        $preparedCommand = $this->prepareCommandAndConfigData($commandId, $projectId, $serverName);
        if($preparedCommand['status'] != 'success' || empty($preparedCommand['response'])){
            return response()->json($preparedCommand);
        }
        $result = $ssh->exec($preparedCommand['response']);
        $responseHtml = view('response',['responsedata' => $result, 'preparedConfigData' => $preparedCommand['preparedConfigData'] ])->render();
        return [
            'status' => 'success',
            'responseHtml' =>  $responseHtml,        
        ];
    }


    public function prepareCommandAndConfigData($commandId,$projectId,$serverName='20'){
        $preparedConfigData = [];
        $configFolderData = config("serversData.folderData");
        $commands = config("serversData.commands");

        if(empty($commandId) || empty($projectId) || empty($serverName) || (empty($configFolderData) || empty($configFolderData[$serverName]) || !array_key_exists($projectId,$configFolderData[$serverName]) || empty($configFolderData[$serverName][$projectId]))){
            return [
                'status' => 'failed',
                'error_message' => 'something went wrong'                
            ];
        }

        $projectFolderData = $configFolderData[$serverName][$projectId];
        $command = '';
        if(array_key_exists($commandId,$commands) && empty($commands[$commandId])){
            return [
                'status' => 'failed',
                'error_message' => 'Command does not exist'             
            ];
        }
        $preparedConfigData['projectFolederName'] = $projectFolderData['folderName'];
        if(!empty($projectFolderData['folderName'])){
            $command .= 'cd ';
            $baseUrl = $projectFolderData['baseUrl'] ?? '';
            $command .= $baseUrl.''.$projectFolderData['folderName'];
            $command .= ' && '.$commands[$commandId];
        }

        return [
            'status' => 'success',
            'response' => $command,
            'preparedConfigData' => $preparedConfigData            
        ];
    }

    public function projectData(){
        $serverName = request()->input('serverName');
        $configFolderData = config("serversData.folderData");
        if(empty($configFolderData) || empty($configFolderData[$serverName])){
            return 'not found';
        }

        return view('projectTable',['projectData' => $configFolderData[$serverName]] )->render();
    }
}
