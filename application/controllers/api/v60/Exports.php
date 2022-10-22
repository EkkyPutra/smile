<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
include_once(APPPATH . "controllers/base/constant.php");
include_once(APPPATH . "controllers/api/components/API_Controller.php");
include_once(APPPATH . "controllers/api/components/Activities/Create.php");
include_once(APPPATH . "controllers/api/components/Activities/Get.php");
include_once(APPPATH . "controllers/api/components/Activities/Remove.php");
include_once(APPPATH . "controllers/api/components/Activities/Update.php");

class Exports extends API_Controller
{
    private $res_code = 201;
    private $res_message = "";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array(
            'url',
            'url_helper',
            'file'
        ));

        $this->load->model(array(
            'master',
            'user',
            'project'
        ));

        $this->load->library(array(
            'myutils'
        ));
    }

    public function users()
    {
        $this->writeLogInput();

        try {
            $fname = time() . "_users.csv";
            $outputUsers = fopen(FCPATH . '/files/' . $fname, "w");
            $totalUsers = $this->user->totalUsers();

            $headerUsers = array('No', 'Nama', 'Role', 'Divisi', 'Nomor Telp');

            fputcsv($outputUsers, $headerUsers, ";");

            if ($totalUsers > 0) {
                $getUsers = $this->user->getUsers();
                if (!is_null($getUsers)) {
                    foreach ($getUsers as $x => $user) {
                        $row = [
                            ($x + 1),
                            $user->name,
                            ucwords($user->user_role),
                            ucwords($user->user_divisi),
                            $user->handphone
                        ];

                        fputcsv($outputUsers, $row, ";");
                    }
                }
            }
            fclose($outputUsers);

            $this->res_code = 200;
            $this->responseObj = [
                "name" => "Export Users",
                "item" => base_url() . 'files/' . $fname
            ];
            $this->sendResponse($this->res_code, $this->res_message);
       } catch (Exception $e) {
            $this->sendResponseError($e);
        }
        $this->writeLogOutput();
    }

    public function projects()
    {
        $this->writeLogInput();

        try {
            $fname = time() . "_projects.csv";
            $outputProjects = fopen(FCPATH . '/files/' . $fname, "w");
            $totalProjects = $this->project->totalProjects();

            $headerUsers = array('No', 'Nama Project', 'Divisi', 'Priority', 'Tipe', 'Batas Waktu', 'Progress', 'PIC Leader', 'PIC Member');

            fputcsv($outputProjects, $headerUsers, ";");

            if ($totalProjects > 0) {
                $getProjects = $this->project->getProjects();
                if (!is_null($getProjects)) {
                    if (!is_null($getProjects)) {
                        $projectsTop = [];
                        $projectsBottom = [];
                        foreach ($getProjects as $project) {
                            if ($project->progress < 100)
                                $projectsTop[] = $project;
                            else
                                $projectsBottom[] = $project;
                        }
                    }

                    $projects = array_merge($projectsTop, $projectsBottom);

                    foreach ($projects as $x => $project) {
                        $members = null;
                        $projectMembers = $this->project->getProjectMembers($project->id);
                        if (!is_null($projectMembers)) {
                            foreach ($projectMembers as $pMember) {
                                if ($pMember->pic_type == "pic_leader")
                                    $members["leader"][] = $pMember;
                                else
                                    $members["members"][] = $pMember;
                            }
                        }

                        $rowsArray = array();
                        $rowArray = [
                            ($x + 1),
                            $project->name,
                            ucwords($project->project_divisi),
                            ($project->priority == 1 ? "TOP" : ""),
                            strtoupper($project->project_type),
                            date("d F Y", strtotime($project->deadline)),
                            $project->progress . "%"
                        ];
                            
                       if (!is_null($members)) {
                            $rowArray[] = ((!is_null($members) && !is_null($members["leader"])) || (!empty($members) && !empty($members["leader"]))) ? $members["leader"][0]->pic_name : "";

                            if ((!is_null($members) && isset($members["members"])) || (!empty($members) && !empty($members["members"]))) {
                                foreach ($members["members"] as $xM => $member) {
                                    if ($xM == 0) {
                                        $rowArray[] = $member->pic_name;
                                    } else {
                                        $rowArray = ["", "", "", "", "", "", "", "", $member->pic_name];
                                    }
                                    $rowsArray[] = $rowArray;
                                    $rowArray = null;
                                }
                            } else {
                                $rowArray[] = "-";
                                $rowsArray[] = $rowArray;
                                $rowArray = null;
                            }

                            // $rowsArray[] = $rowArray;
                        }

                        foreach ($rowsArray as $row) {
                            fputcsv($outputProjects, $row, ";");
                        }
                        unset($rowsArray);
                        $rowsArray = null;
                    }
                }
            }
            fclose($outputProjects);

            $this->res_code = 200;
            $this->responseObj = [
                "name" => "Export Projects",
                "item" => base_url() . '/files/' . $fname
            ];
            $this->sendResponse($this->res_code, $this->res_message);
        } catch (Exception $e) {
            $this->sendResponseError($e);
        }
        $this->writeLogOutput();
    }

    public function activities($slug)
    {
        $this->writeLogInput();

        try {
            $fname = time() . "_activities.csv";
            $outputActivities = fopen(FCPATH . '/files/' . $fname, "w");
            $totalUsers = $this->user->totalUsers();

            $project = $this->project->getProjectBySlug($slug);
            $projectMembers = $this->project->getProjectMembers($project->id);
            $members = null;
            if (!is_null($projectMembers)) {
                foreach ($projectMembers as $pMember) {
                    if ($pMember->pic_type == "pic_leader")
                        $members["leader"][] = $pMember;
                    else
                        $members["members"][] = $pMember;
                }
            }

            fputcsv($outputActivities, ["", "Nama Project", $project->name], ";");
            fputcsv($outputActivities, ["", "Deskripsi", $project->description], ";");
            fputcsv($outputActivities, ["", "Tipe", $project->project_type], ";");
            fputcsv($outputActivities, ["", "Progress", $project->progress . "%"], ";");
            fputcsv($outputActivities, ["", "Batas Waktu", date("d F Y", strtotime($project->deadline))], ";");
            fputcsv($outputActivities, ["", "Divisi", $project->project_divisi], ";");
            fputcsv($outputActivities, ["", "Link Project", $project->link], ";");
            fputcsv($outputActivities, ["", "PIC Leader", ((!is_null($members) && isset($members["leader"]) ? $members["leader"][0]->pic_name : "-"))], ";");

            if (!is_null($members) && isset($members["members"])) {
                foreach ($members["members"] as $x => $member) {
                    if ($x == 0) {
                        fputcsv($outputActivities, ["", "PIC Member", ($x + 1) . ". " . $member->pic_name], ";");    
                    } else {
                        fputcsv($outputActivities, ["", "", ($x + 1) . ". " . $member->pic_name], ";");
                    }
                }
            }
            fputcsv($outputActivities, ["", "", "", "", ""], ";");
            $headerPerforma = ['No', 'Nama Aktivitas', 'Last Update', 'Aktivitas Progress', 'Evidence'];
            fputcsv($outputActivities, $headerPerforma, ";");

            if ($totalUsers > 0) {
                $activities = $this->project->getProjectActivities(["project_id" => $project->id]);
                if (!is_null($activities)) {
                    foreach ($activities as $x => $activity) {
                        $row = [
                            ($x + 1),
                            $activity->name,
                            date("d F Y", strtotime($activity->updated)),
                            $activity->progress . "%",
                            $activity->evidence
                        ];

                        fputcsv($outputActivities, $row, ";");
                    }
                }
            }
            fclose($outputActivities);

            $this->res_code = 200;
            $this->responseObj = [
                "name" => "Export Activities",
                "item" => base_url() . '/files/' . $fname
            ];
            $this->sendResponse($this->res_code, $this->res_message);
        } catch (Exception $e) {
            $this->sendResponseError($e);
        }
        $this->writeLogOutput();
    }

    public function performances()
    {
        $this->writeLogInput();

        try {
            $fname = time() . "_performance.csv";
            $outputPerformance = fopen(FCPATH . '/files/' . $fname, "w");
            $totalUsers = $this->user->totalUsers();

            $headerPerforma = ['No', 'Nama PIC', 'Divisi', 'Project on Track', 'Project Terlambat', 'Project Selesai'];
            fputcsv($outputPerformance, $headerPerforma, ";");

            $today = date("Y-m-d");
            if ($totalUsers > 0) {
                $getUsers = $this->user->getUsers();
                if (!is_null($getUsers)) {
                    foreach ($getUsers as $x => $user) {
                        $projectOnTrack = $this->project->getCountProject($user->id, $today, "track");
                        $projectComplete = $this->project->getCountProject($user->id, $today, "complete");
                        $projectLate = $this->project->getCountProject($user->id, $today, "late");

                        $row = [
                            ($x + 1),
                            $user->name,
                            ucwords($user->user_divisi),
                            $projectOnTrack,
                            $projectLate,
                            $projectComplete
                        ];

                        fputcsv($outputPerformance, $row, ";");
                    }
                }
            }
            fclose($outputPerformance);

            $this->res_code = 200;
            $this->responseObj = [
                "name" => "Export Performance",
                "item" => base_url() . '/files/' . $fname
            ];
            $this->sendResponse($this->res_code, $this->res_message);
        } catch (Exception $e) {
            $this->sendResponseError($e);
        }
        $this->writeLogOutput();
    }
}