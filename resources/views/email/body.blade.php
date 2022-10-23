<html>
    <body style="margin: 0; padding: 0; font-weight: 400; font-size: 15px;">
        <div class="container">
            <div style="margin: 0 auto; font-family: century gothic; max-width: 650px; min-width: 320px;">
                <div style="text-align: center; background: #f3f3f3; padding: 50px 0; margin: 0 0 30px 0;">
                    <div style="font-size: 1.3em; color: #bbbfc3; text-transform: uppercase; font-weight: bold;">Sablayan - Tourism</div>
                </div>
                <div style="max-width: 500px; margin: 0 auto;">
                    <p style="margin-bottom: 15px;">Hi, 
                        <span span style=" font-weight: 600; display: inline-block; width: 100px; color: #555;"> {{ $mail_data['lawyer_name'] }}</span>
                    </p>

                    <p>You are receiving this email of a client's appointment. The details are below.</p><br>
                    
                    <p style=" margin: 10px 0;"><span span style=" font-weight: 600; display: inline-block; width: 100px; color: #555;"> Name : </span>  {{$mail_data['client_name']}} </p>
                    <p style=" margin: 10px 0;"><span span style=" font-weight: 600; display: inline-block; width: 100px; color: #555;"> Service : </span>  {{$mail_data['service']}} </p>
                    <p style=" margin: 10px 0;"><span span style=" font-weight: 600; display: inline-block; width: 100px; color: #555;"> Start Time: </span>  {{$mail_data['start_time']}} </p>
                    <p style=" margin: 10px 0;"><span span style=" font-weight: 600; display: inline-block; width: 100px; color: #555;"> Finish Time : </span>  {{$mail_data['finish_time']}} </p>     
                
                    <br/>
                
                    <p> Regards,  </p>
                    <p> Appointment System  </p>
                    <br/><br/>
            
                <div style="background: #f3f3f3; padding: 50px 0; margin: 30px 0 0 0;">
                    <p style="text-align: center; font-size: 0.75em; color: grey;">© 2022 PAO Appointment. All rights reserved.</p>
                    <p style="text-align: center; font-size: 0.75em; color: grey;">This email is auto-generated. Please do not reply here.</p>
                </div>
            </div>
        </div>
    </body>
</html>