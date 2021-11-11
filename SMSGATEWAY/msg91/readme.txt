msg91

FOR SIMPLE SMS
1)USE ONE API
  ->Add Sender Id(DLT Approved)
  ->Add Templet
  ->Add Flow Templet
  ->Add ##Var## Parameters same as approved dlt templet
  ->Use Send Sms Using Flow
  ->Pass Variable same as templet Params
  ->Send Work For Me
  
  For OTP
  
  1)USE Send Otp API
    ->Add Send Otp Templet With Sender Id and Variable
    ->After Send OTP. Success Responce
    ->Use Verify Otp Api for Verification On msg91 panel
    ->Verification Done on msg91
  
