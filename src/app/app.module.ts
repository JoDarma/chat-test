import { HttpClientModule } from '@angular/common/http';
import { CUSTOM_ELEMENTS_SCHEMA, Injector, NgModule } from '@angular/core';

import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { AuthModule } from './auth/auth.module';
import { HomeComponent } from './home/home.component';
import { AuthGuard } from './service/auth-guard.service';
import { ConversationComponent } from './conversation/conversation.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { UtilisateurListModalComponent } from './utilisateur-list-modal/utilisateur-list-modal.component';

@NgModule({
  declarations: [
    AppComponent,
    HomeComponent,
    ConversationComponent,
    UtilisateurListModalComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    AuthModule,
    FormsModule,
    ReactiveFormsModule,

  ],
  providers: [AuthGuard],
  bootstrap: [AppComponent],
  schemas: [CUSTOM_ELEMENTS_SCHEMA],

})
export class AppModule { }
