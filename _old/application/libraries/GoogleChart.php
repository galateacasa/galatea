<?

  /**
   * Generates the scripts to be used into the page to create a google chart
   * @see https://developers.google.com/chart/
   * 
   * Is necessary to set up the object with the database structure.
   * Is also necessary to include both, inline and remote scripts into the page to the chart work property.
   * The default chart tag ID name is "chart_div", if you want to change it, take a look at setTagName() method.
   */
  class GoogleChart
  {
    /**
     * Script to be included to generate the chart
     * @var string
     */
    private $chart_script = 'https://www.google.com/jsapi';

    /**
     * Pattern to be used
     * @var string
     */
    private $chart_pattern = "['%s/%s', %s],";

    /**
     * Values to be included into the chart parameter at JavaScript
     * @var string
     */
    private $chart_values = '';

    /**
     * Object with the chart values
     * @var object
     */
    private $item;

    /**
     * Tag name to be used into the inline script
     * @var string
     */
    private $tag_name = 'chart_div';

    /**
     * Generate the values to be used at the JavaScript file
     * @return string
     */
    private function generateInlineScript()
    {
      try{

        # Check if the item was set
        if($this->item){

          # Get all values from current month
          for($month = 1; $month < 12; $month++)
          {
            # Get current year
            $year = date('Y');

            # Set start date and time
            $start_date = "'" . "$year-$month-01 " . "00:00:00'";

            # Set end date and time
            $end_date = "'" . "$year-$month-31 " . "23:59:59'";

            # Colect the total of votes
            $total_votes = $this->item->item_vote->where_between('create_date', $start_date, $end_date)->count();

            $this->chart_values .= sprintf($this->chart_pattern, $month, date('Y'), $total_votes);
          }

          # Remove the last "," (comma) from the end of the string
          $this->chart_values = substr($this->chart_values, 0, -1);

          $inline_script = <<<CHART
            google.load("visualization", "1", {packages:["corechart"]});
            google.setOnLoadCallback(drawChart);

            function drawChart() {
              var data = google.visualization.arrayToDataTable([
                ['Mês', 'Votos'],
                {$this->chart_values}
              ]);

              var options = {
                hAxis: {title: 'Mês', titleTextStyle: {color: '#191919'}},
                colors: ['#525252'],
                backgroundColor: '#f2f4f2'
              };

              var chart = new google.visualization.ColumnChart( document.getElementById('{$this->tag_name}') );
              chart.draw(data, options);
            }
CHART;

          return $inline_script;

        }else{
          throw new Exception('The object with the items to be used to create the graphic was not set.');
        }
        
      }catch(Exception $e){
        return $e->getMessage();
      }
    }

    /**
     * Set the object that have the informations
     * @param object $item Object with the informations
     */
    public function setItem($item){
      $this->item = $item;
    }

    /**
     * Set the tag name to the chart
     * @param string $tag_name Tag name
     */
    public function setTagName($tag_name){
      $this->tag_name = $tag_name;
    }

    /**
     * Get the script that need to be included into the page
     * @return string JavaScript code that generates the google chart
     */
    public function getInlineScript(){
      return $this->generateInlineScript();
    }

    /**
     * Get Google Chart JavaScript URL to be used
     * @return string URL to the JavaScript
     */
    public function getRemoteScript(){
      return $this->chart_script;
    }

  }

?>