import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { Utilisateur } from 'src/app/models/utilisateur.model';
import { AuthService } from 'src/app/service/auth.service';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss']
})
export class RegisterComponent implements OnInit {

  registerForm: FormGroup;
  loading = false;
  submitted = false;
  returnUrl: string;
  error = '';
  
  constructor(
    private formBuilder: FormBuilder,
    private route: ActivatedRoute,
    private router: Router,
    private authService: AuthService
  ) { }

  ngOnInit(): void {
    this.registerForm = this.formBuilder.group({
      nom:['', Validators.required],
      prenom:['', Validators.required],
      addMail: ['', Validators.required],
      mdp: ['', Validators.required]
    });
  }


  get f() { return this.registerForm.controls; } 

  onSubmit() {
    this.submitted = true;

    // stop here if form is invalid
    if (this.registerForm.invalid) {
        return;
    }

    let user = new Utilisateur(this.f.nom.value,this.f.prenom.value,this.f.addMail.value,this.f.mdp.value)

    this.loading = true;

    this.authService.register(user).subscribe(response => {

      this.router.navigateByUrl('/tchat')
      console.log('ok')
      this.loading = false;

    }, 
    error => {
      if(error.status === 400){
        this.error = "identifiants incorrect"
      }
      this.loading = false;

      this.registerForm.reset()
    });
  }

}
