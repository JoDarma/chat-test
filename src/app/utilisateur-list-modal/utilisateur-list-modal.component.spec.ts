import { ComponentFixture, TestBed } from '@angular/core/testing';

import { UtilisateurListModalComponent } from './utilisateur-list-modal.component';

describe('UtilisateurListModalComponent', () => {
  let component: UtilisateurListModalComponent;
  let fixture: ComponentFixture<UtilisateurListModalComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ UtilisateurListModalComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(UtilisateurListModalComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
