import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DaftarTransactionComponent } from './daftar-transaction.component';

describe('DaftarTransactionComponent', () => {
  let component: DaftarTransactionComponent;
  let fixture: ComponentFixture<DaftarTransactionComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DaftarTransactionComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DaftarTransactionComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
