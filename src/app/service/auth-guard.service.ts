import { ActivatedRouteSnapshot, CanActivate, Router, RouterStateSnapshot } from '@angular/router';
import { Observable } from 'rxjs';
import { AuthService } from './auth.service';
import { Injectable } from '@angular/core';

@Injectable()
export class AuthGuard implements CanActivate {

  constructor(private authService: AuthService,
              private router: Router) { }

    canActivate() {
      if (!this.authService.isLoggedIn()) {
        this.router.navigate(['/connexion']);
        return false;
      } else {
        return true;
      }
    }
}