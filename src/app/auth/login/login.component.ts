import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { AuthService } from 'src/app/service/auth.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {
  loginForm: FormGroup;
  loading = false;
  submitted = false;
  returnUrl: string;
  error = '';

  constructor(
      private formBuilder: FormBuilder,
      private route: ActivatedRoute,
      private router: Router,
      private authService: AuthService
  ) { 

  }

  ngOnInit() {
      this.loginForm = this.formBuilder.group({
          addMail: ['', Validators.required],
          mdp: ['', Validators.required]
      });

  }

  // convenience getter for easy access to form fields
  get f() { return this.loginForm.controls; } 

  onSubmit() {
      this.submitted = true;

      // stop here if form is invalid
      if (this.loginForm.invalid) {
          return;
      }

      this.loading = true;

      this.authService.login(this.f.addMail.value,this.f.mdp.value).subscribe(response => {

        this.router.navigateByUrl('/tchat')
        console.log('ok')
        this.loading = false;

      }, 
      error => {
        if(error.status === 400){
          this.error = "identifiants incorrect"
        }
        this.loading = false;

      });
    }

}
