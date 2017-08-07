<?php


use Illuminate\Database\Seeder;

class CollegesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('colleges')->insert([
			['name' => 'AAA college of Engineering', 'location' => 'Virudhunagar'],
			['name' => 'Adhiparasakthi Engineering College', 'location' => 'Melmaruvathur'],
			['name' => 'The American College Madurai', 'location' => 'Madurai'],
			['name' => 'Bannari Amman Institute of Technology', 'location' => 'Erode'],
			['name' => 'Bharat Nikethan Engineering College', 'location' => 'Theni'],
			['name' => 'Francis Xavier Engineering College', 'location' => 'Tirunelveli'],
			['name' => 'Jai Shree Ram Group Of Institutions', 'location' => 'Tirupur'],
			['name' => 'KLN Engineering College', 'location' => 'Madurai'],
			['name' => 'KLN Information Technology', 'location' => 'Madurai'],
			['name' => 'Kongu Engineering College', 'location' => 'Erode'],
			['name' => 'Madurai Institute Of Engineering And Technology', 'location' => 'Sivagangai'],
			['name' => 'Mutthayammal College Of Engineering', 'location' => 'Rasipuram'],
			['name' => 'Vidhya Mandhir Institute of Technology', 'location' => 'Erode'],
			['name' => 'V.P.Muthaiah Pillai Meenakshi Ammal Engineering College For Women', 'location' => 'Krishnankoil'],
			['name' => 'Thutookudi Government Medical College', 'location' => 'Thoothukudi'],
			['name' => 'Thiyagaraja College of Engineering', 'location' => 'Madurai'],
			['name' => 'NSN college of Engineering', 'location' => 'Karur'],
			['name' => 'P.S.R.Rengasamy College of Engineering for women', 'location' => 'Sivakasi'],
			['name' => 'Rajas Engineering College,vaddakkangulam', 'location' => 'Nagercoil'],
			['name' => 'Rover Engineering College', 'location' => 'Perambalur'],
			['name' => 'S.Veerasamy chettiyar college of Engineering & Technology', 'location' => 'Puliyangudi'],
			['name' => 'Sasurie Academy of Engineering,Kariyampalyam', 'location' => 'Coimbatore'],
			['name' => 'Shivani College of Engineering & Technology', 'location' => 'Tiruchirapalli'],
			['name' => 'Sethu Institute of Technology', 'location' => 'Virudhunagar'],
			['name' => 'St.Joseph Institute of Management', 'location' => 'Tiruchirappalli'],
			['name' => 'SRM UNIVERSITY', 'location' => 'Chennai'],
			['name' => 'Kalasalingam Institute of Technology', 'location' => 'Krishnankoil'],
			['name' => 'Sri vidhya college of Engineering', 'location' => 'Virudhunagar'],
			['name' => 'Sri Kaleeswari College', 'location' => 'Sivakasi'],
			['name' => 'St.Josephs College of Engineering and Technology', 'location' => 'Thanjavur'],
			['name' => 'VV College of Engineering', 'location' => 'Tirunelveli'],
			['name' => 'Vikram College of Engineering', 'location' => 'Enathi'],
			['name' => 'Mahakavi Bharathiyar College of Engineering and Technology', 'location' => 'Vasudevanallur'],
			['name' => 'Kalasalingam University', 'location' => 'Virudhunagar'],
			['name' => 'Pet Engineering college', 'location' => 'Vallioor'],
			['name' => 'Vaigai College of Engineering', 'location' => 'Madurai'],
			['name' => 'Sri Venkateshwara Institute of IT and Management', 'location' => 'Coimbatore'],
			['name' => 'RVS College of Engineering', 'location' => 'Dindigul'],
			['name' => 'National College of Engineering', 'location' => 'kovilpatti'],
			['name' => 'JJ College of Engineering and Technology', 'location' => 'Tiruchirapalli'],
			['name' => 'M.Kumarasamy College of Engineering', 'location' => 'Karur'],
			['name' => 'Ayya Nadar Janaki Ammal College', 'location' => 'Sivakasi'],
			['name' => 'Mangayarkarasi College of Engineering', 'location' => 'Madurai'],
			['name' => 'Mannar Thirumalai Naicker College', 'location' => 'Madurai'],
			['name' => 'Subbulakshmi Lakshmipathy College of Science', 'location' => 'Madurai'],
			['name' => 'Udaya School of Engineering', 'location' => 'Kanyakumari'],
			['name' => 'K.Ramakrishna College of Technology', 'location' => 'Tiruchirapalli']
        ]);
    }
}
