<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;
use App\Models\Column;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use ZipArchive;
use DB;

class DemoController extends Controller
{
    public function showTasks()
        {

            $columns = Column::with('cards')->get();
           

            return view('demos.alltasks',compact('columns'));
        }

        public function addColumn(Request $request){
           
           $column = new Column;
           $column->title = $request->title;
           $column->save();
           $column->load(['cards']);
           return $column;
        }

        public function addCard(Request $request){
           
           $card = new Card;
           $card->column_id = $request->column_id;
           $card->title = $request->title;
           $card->description = $request->description;
           $card->status = 0;
           $card->save();
           return $card;
        }

        public function updateTasksStatus(Request $request, $id)
        {
            $this->validate($request, [
                'column_id' => 'required',
            ]);

            $task = Card::find($id);
            $task->column_id = $request->column_id;
            $task->save();
            
            return response('Updated Successfully.', 200);

        }

        public function updateTasksOrder(Request $request)
        {
            $this->validate($request, [
                'tasks.*.order' => 'required|numeric',
            ]);

            $tasks = Card::all();

            foreach ($tasks as $task) {
                $id = $task->id;
                foreach ($request->tasks as $tasksNew) {
                    if ($tasksNew['id'] == $id) {
                        $task->update(['order' => $tasksNew['order']]);
                    }
                }
            }

            return response('Updated Successfully.', 200);
        }

         public function updateCard(Request $request, $id)
        {
            

            $task = Card::find($id);
            $task->title = $request->title;
            $task->description = $request->description;
            $task->save();
            
            return response('Updated Successfully.', 200);

        }

        public function destroy($id)
        {
            $column_data = Column::find($id);
            $column_data->cards()->delete();
            $column_data->delete();
            return response('Column Deleted Successfully.', 200);
        }

        public function downloadDB(){

            $dbname = 'demotask';
            $dbusername = 'root';
            $dbpassword = 'Peekdb@786#';
            $dbhost = 'localhost';
            // dd(DB);
            $backup_name = "backup.sql";
            $tables = array();
        $result = DB::select('SHOW TABLES');
        foreach ($result as $table) {
            foreach ($table as $key => $value)
               $tables[] = $value;
        }
        // $tables = array("users", "villages", "migrations", "failed_jobs", "password_resets"); //here your tables...
        $connect = new \PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", "$dbusername", "$dbpassword",array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $get_all_table_query = "SHOW TABLES";
        $statement = $connect->prepare($get_all_table_query);
        $statement->execute();
        $result = $statement->fetchAll();
    
        $output = '';
        foreach($tables as $table)
        {
            $show_table_query = "SHOW CREATE TABLE " . $table . "";
            $statement = $connect->prepare($show_table_query);
            $statement->execute();
            $show_table_result = $statement->fetchAll();
    
            foreach($show_table_result as $show_table_row)
            {
                $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
            }
            $select_query = "SELECT * FROM " . $table . "";
            $statement = $connect->prepare($select_query);
            $statement->execute();
            $total_row = $statement->rowCount();
    
            for($count=0; $count<$total_row; $count++)
            {
                $single_result = $statement->fetch(\PDO::FETCH_ASSOC);
                $table_column_array = array_keys($single_result);
                $table_value_array = array_values($single_result);
                $output .= "\nINSERT INTO $table (";
                $output .= "" . implode(", ", $table_column_array) . ") VALUES (";
                $output .= "'" . implode("','", $table_value_array) . "');\n";
            }
        }
        $file_name = public_path('sql/database_backup_on_' . date('y-m-d') . '.sql');
        $file_handle = fopen($file_name, 'w+');
        fwrite($file_handle, $output);
        fclose($file_handle);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file_name));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_name));
        ob_clean();
        flush();
        readfile($file_name);
        unlink($file_name);
      
        
    }
}
