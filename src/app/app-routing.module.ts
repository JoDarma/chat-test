import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { LoginComponent } from './auth/login/login.component';
import { RegisterComponent } from './auth/register/register.component';
import { HomeComponent } from './home/home.component';
import { AuthGuard } from './service/auth-guard.service';

const routes: Routes = [
  {path:"inscription", component:RegisterComponent},
  {path:"connexion", component:LoginComponent},
  {path:"tchat",canActivate:[AuthGuard],component:HomeComponent},
  { path: '',pathMatch:'full', redirectTo:'tchat'},
  { path: '**', redirectTo: 'not-found' }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
